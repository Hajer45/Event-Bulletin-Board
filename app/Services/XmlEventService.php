<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Collection;
use SimpleXMLElement;

class XmlEventService
{
    /**
     * Export events to XML format.
     *
     * @param Collection $events
     * @return string
     */
    public function exportToXml(Collection $events): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><events></events>');

        foreach ($events as $event) {
            $eventNode = $xml->addChild('event');
            $eventNode->addChild('title', htmlspecialchars($event->title));
            $eventNode->addChild('description', htmlspecialchars($event->description));
            $eventNode->addChild('location', htmlspecialchars($event->location));
            $eventNode->addChild('event_date', $event->event_date->format('Y-m-d H:i:s'));

            if ($event->registration_deadline) {
                $eventNode->addChild('registration_deadline', $event->registration_deadline->format('Y-m-d H:i:s'));
            }

            if ($event->max_participants) {
                $eventNode->addChild('max_participants', $event->max_participants);
            }

            $eventNode->addChild('status', $event->status);
        }

        // Format the XML with proper indentation
        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;

        return $dom->saveXML();
    }

    /**
     * Import events from XML file.
     *
     * @param string $xmlContent
     * @param int $userId
     * @return array
     */
    public function importFromXml(string $xmlContent, int $userId): array
    {
        try {
            // Disable XML entity loading to prevent XXE attacks
            libxml_disable_entity_loader(true);

            $xml = new SimpleXMLElement($xmlContent);
            $imported = [];
            $errors = [];

            foreach ($xml->event as $eventNode) {
                try {
                    $eventData = [
                        'user_id' => $userId,
                        'title' => (string) $eventNode->title,
                        'description' => (string) $eventNode->description,
                        'location' => (string) $eventNode->location,
                        'event_date' => (string) $eventNode->event_date,
                        'registration_deadline' => isset($eventNode->registration_deadline) ? (string) $eventNode->registration_deadline : null,
                        'max_participants' => isset($eventNode->max_participants) ? (int) $eventNode->max_participants : null,
                        'status' => (string) $eventNode->status,
                    ];

                    // Validate the event data
                    $this->validateEventData($eventData);

                    // Create the event
                    $event = Event::create($eventData);
                    $imported[] = $event;

                } catch (\Exception $e) {
                    $errors[] = "Error importing event '{$eventNode->title}': " . $e->getMessage();
                }
            }

            return [
                'success' => count($imported),
                'errors' => $errors,
                'events' => $imported,
            ];

        } catch (\Exception $e) {
            throw new \Exception('Invalid XML format: ' . $e->getMessage());
        }
    }

    /**
     * Validate XML structure.
     *
     * @param string $xmlContent
     * @return bool
     */
    public function validateXmlStructure(string $xmlContent): bool
    {
        try {
            libxml_use_internal_errors(true);
            $xml = new SimpleXMLElement($xmlContent);

            // Check if root element is 'events'
            if ($xml->getName() !== 'events') {
                return false;
            }

            // Check if there's at least one event
            if (count($xml->event) === 0) {
                return false;
            }

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate event data before import.
     *
     * @param array $data
     * @throws \Exception
     */
    private function validateEventData(array $data): void
    {
        if (empty($data['title'])) {
            throw new \Exception('Title is required');
        }

        if (empty($data['description'])) {
            throw new \Exception('Description is required');
        }

        if (empty($data['location'])) {
            throw new \Exception('Location is required');
        }

        if (empty($data['event_date'])) {
            throw new \Exception('Event date is required');
        }

        if (!in_array($data['status'], ['draft', 'published', 'cancelled'])) {
            throw new \Exception('Invalid status');
        }
    }
}
