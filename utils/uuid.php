<?php

/**
 * UUID Helper Functions
 * Provides UUID generation and validation utilities
 */

use Ramsey\Uuid\Uuid;

if (!function_exists('generateUUID')) {
    /**
     * Generate a new UUID v4
     * 
     * @return string UUID in string format (36 characters)
     */
    function generateUUID(): string
    {
        return Uuid::uuid4()->toString();
    }
}

if (!function_exists('isValidUUID')) {
    /**
     * Validate if a string is a valid UUID
     * 
     * @param string $uuid The UUID to validate
     * @return bool True if valid UUID, false otherwise
     */
    function isValidUUID(string $uuid): bool
    {
        return Uuid::isValid($uuid);
    }
}

if (!function_exists('uuidToBinary')) {
    /**
     * Convert UUID string to binary format (for storage optimization if needed)
     * 
     * @param string $uuid The UUID string
     * @return string Binary representation
     */
    function uuidToBinary(string $uuid): string
    {
        try {
            return Uuid::fromString($uuid)->getBytes();
        } catch (Exception $e) {
            error_log('UUID conversion error: ' . $e->getMessage());
            return '';
        }
    }
}

if (!function_exists('binaryToUuid')) {
    /**
     * Convert binary UUID to string format
     * 
     * @param string $binary Binary UUID
     * @return string UUID string
     */
    function binaryToUuid(string $binary): string
    {
        try {
            return Uuid::fromBytes($binary)->toString();
        } catch (Exception $e) {
            error_log('UUID conversion error: ' . $e->getMessage());
            return '';
        }
    }
}

