<?php

namespace Tests\Traits;

trait AssertionsTrait
{
    protected function assertDateTime(
        string $datetime,
        string $message = null,
    ): void {
        $this->assertMatchesRegularExpression(
            '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/',
            $datetime,
            $message ??
                'Failed asserting that given datetime has correct format.',
        );
    }
}
