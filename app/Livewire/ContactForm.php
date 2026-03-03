<?php

namespace App\Livewire;

use App\Mail\ContactFormMail;
use App\Models\Contact;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $service_type = '';
    public string $subject = '';
    public string $message = '';
    public string $honeypot = '';

    public bool $submitted = false;
    public string $rateLimitError = '';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'service_type' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min' => 'Pesan minimal 10 karakter.',
        ];
    }

    public function submit(): void
    {
        // Honeypot check
        if ($this->honeypot !== '') {
            return;
        }

        // Rate limiting: 3 submissions per IP per hour
        $key = 'contact-form:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);
            $this->rateLimitError = "Terlalu banyak pesan. Silakan coba lagi dalam {$minutes} menit.";
            return;
        }

        $validated = $this->validate();

        try {
            $contact = Contact::create($validated);
            RateLimiter::hit($key, 3600); // 1 hour decay

            // Forward pesan ke email admin
            try {
                Mail::to('indrajayabta414@gmail.com')->send(new ContactFormMail($contact));
            } catch (\Exception $e) {
                // Email gagal tapi pesan tetap tersimpan di database
                \Illuminate\Support\Facades\Log::warning('Contact email forwarding failed: ' . $e->getMessage());
            }

            $this->reset(['name', 'email', 'phone', 'service_type', 'subject', 'message', 'rateLimitError']);
            $this->submitted = true;

            $this->dispatch('contact-sent');
        } catch (\Exception $e) {
            $this->addError('message', 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.');
        }
    }

    public function resetForm(): void
    {
        $this->submitted = false;
        $this->rateLimitError = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.contact-form', [
            'services' => Service::active()->orderBy('order')->get(),
        ]);
    }
}
