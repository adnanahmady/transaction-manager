<?php

namespace App\Http\Middleware;

use App\Support\Numbers\NumberTranslator;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslatorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $this->translateNumbers($request);

        return $next($request);
    }

    private function translateNumbers(Request $request): void
    {
        $translator = new NumberTranslator();
        $data = array_map(
            fn($value) => $translator->translate($value),
            $request->all(),
        );
        $request->merge($data);
    }
}
