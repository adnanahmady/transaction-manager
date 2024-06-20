<?php

namespace Tests\Unit\Middlewares;

use App\Support\Numbers\NumberTranslator;
use Tests\TestCase;

class NumberTranslatorTest extends TestCase
{
    public function test_it_should_leave_non_numerics_untouched(): void
    {
        $translator = new NumberTranslator();

        $text = $translator->translate('۱۲۳-۴_۵۶۷۸۹۰ss-سی');

        $this->assertSame(
            '123-4_567890ss-سی',
            $text,
        );
    }

    public function test_it_should_translate_persian_numbers_to_english(): void
    {
        $translator = new NumberTranslator();

        $numbers = $translator->translate('۱۲۳۴۵۶۷۸۹۰');

        $this->assertSame(
            '1234567890',
            $numbers,
        );
    }
}
