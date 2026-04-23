<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

/**
 * AntispamService
 * This service provides various methods to validate incoming requests for spam prevention.
 * It includes rate limiting, honeypot field checking, submission timing validation, content analysis, and reCAPTCHA verification.
 */
class AntispamService
{
    protected int $minSubmitSeconds = 5;

    protected int $maxAttemptsPerMinute = 5;

    public function validate(Request $request): void
    {
        $this->checkRateLimit($request);
        $this->checkHoneypot($request);
        $this->checkSubmitTiming($request);
        $this->checkContent($request);
        if ($request->has('g-recaptcha-response')) {
            //   $this->checkRecaptcha($request);
        }
    }

    protected function checkRateLimit(Request $request): void
    {
        $key = 'contact-form:'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, $this->maxAttemptsPerMinute)) {
            abort(429, 'Too many attempts. Please try again later.');
        }

        RateLimiter::hit($key, 60);
    }

    protected function checkHoneypot(Request $request): void
    {
        if ($request->filled('company')) {
            abort(403, 'Spam detected.');
        }
    }

    protected function checkSubmitTiming(Request $request): void
    {
        $formLoadedAt = (int) $request->input('form_loaded_at');

        if (! $formLoadedAt || now()->timestamp - $formLoadedAt < $this->minSubmitSeconds) {
            abort(403, 'Submission too fast.');
        }
    }

    protected function checkContent(Request $request): void
    {
        $content = $request->input('message', '');

        if (! $content) {
            return; // skip if not present
        }

        if (preg_match('/https?:\/\//i', $content)) {
            abort(403, 'Links are not allowed.');
        }

        if (preg_match('/(.)\\1{6,}/', $content)) {
            abort(403, 'Spam pattern detected.');
        }

        $blacklist = ['crypto', 'bitcoin', 'casino', 'viagra', 'loan', 'forex'];

        foreach ($blacklist as $word) {
            if (Str::contains(Str::lower($content), $word)) {
                abort(403, 'Spam content detected.');
            }
        }
    }

    /*
    protected function checkRecaptcha(Request $request): void
    {
      $token = $request->input('g-recaptcha-response');
      if (! $token) {
        abort(403, 'Captcha verification failed.');
      }
/* @var \Illuminate\Http\Client\Response $response
      $response = Http::asForm()->post(
        'https://www.google.com/recaptcha/api/siteverify',
        [
          'secret' => config('services.recaptcha.secret'),
          'response' => $token,
          'remoteip' => $request->ip(),
        ]
      );
      //  dd($response->json());

      if (! $response->ok()) {
        abort(403, 'Captcha verification error.');
      }

      $data = $response->json();

      if (
        ! $data['success'] ||
        (isset($data['score']) && $data['score'] < config('services.recaptcha.min_score', 0.5))
      ) {
        abort(403, 'Captcha validation failed.');
      }
    }
      */
}
