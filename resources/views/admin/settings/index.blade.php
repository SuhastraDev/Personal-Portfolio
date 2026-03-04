@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Pengaturan Website</h1>
    <p class="text-sm text-gray-500 mt-1">Kelola konten dinamis website Anda.</p>
</div>

{{-- Tabs --}}
<div x-data="{ activeTab: '{{ request('tab', 'hero') }}' }" class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="border-b border-gray-200">
        <nav class="flex overflow-x-auto -mb-px" aria-label="Tabs">
            <button @click="activeTab = 'hero'" :class="activeTab === 'hero' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                Hero Section
            </button>
            <button @click="activeTab = 'about'" :class="activeTab === 'about' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                Tentang Saya
            </button>
            <button @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                Kontak & Sosmed
            </button>
            <button @click="activeTab = 'general'" :class="activeTab === 'general' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                General
            </button>
        </nav>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="active_tab" :value="activeTab">

        <div class="p-6">
            {{-- Tab: Hero --}}
            <div x-show="activeTab === 'hero'" x-cloak>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Hero Section</h3>
                <div class="space-y-4 max-w-2xl">
                    <div>
                        <label for="hero_title" class="block text-sm font-medium text-gray-700 mb-1">Judul Hero</label>
                        <input type="text" name="hero_title" id="hero_title" value="{{ $raw['hero_title'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="hero_subtitle" class="block text-sm font-medium text-gray-700 mb-1">Subtitle Hero</label>
                        <input type="text" name="hero_subtitle" id="hero_subtitle" value="{{ $raw['hero_subtitle'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="hero_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Hero</label>
                        <textarea name="hero_description" id="hero_description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ $raw['hero_description'] ?? '' }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="hero_cta_text" class="block text-sm font-medium text-gray-700 mb-1">Teks Tombol CTA</label>
                            <input type="text" name="hero_cta_text" id="hero_cta_text" value="{{ $raw['hero_cta_text'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>
                        <div>
                            <label for="hero_cta_url" class="block text-sm font-medium text-gray-700 mb-1">URL Tombol CTA</label>
                            <input type="text" name="hero_cta_url" id="hero_cta_url" value="{{ $raw['hero_cta_url'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>
                    </div>

                    {{-- 🌐 English Translation --}}
                    <div class="border-l-4 border-blue-400 pl-4 space-y-4 mt-6">
                        <h4 class="text-sm font-semibold text-blue-700">🌐 English Translation</h4>
                        <div>
                            <label for="en_hero_title" class="block text-sm font-medium text-blue-600 mb-1">Hero Title (EN)</label>
                            <input type="text" name="en[hero_title]" id="en_hero_title" value="{{ $rawEn['hero_title'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="e.g. Hello, I am...">
                        </div>
                        <div>
                            <label for="en_hero_subtitle" class="block text-sm font-medium text-blue-600 mb-1">Hero Subtitle (EN)</label>
                            <input type="text" name="en[hero_subtitle]" id="en_hero_subtitle" value="{{ $rawEn['hero_subtitle'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="e.g. Full Stack Developer">
                        </div>
                        <div>
                            <label for="en_hero_description" class="block text-sm font-medium text-blue-600 mb-1">Hero Description (EN)</label>
                            <textarea name="en[hero_description]" id="en_hero_description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="English description...">{{ $rawEn['hero_description'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label for="en_hero_cta_text" class="block text-sm font-medium text-blue-600 mb-1">CTA Button Text (EN)</label>
                            <input type="text" name="en[hero_cta_text]" id="en_hero_cta_text" value="{{ $rawEn['hero_cta_text'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="e.g. View My Work">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab: About --}}
            <div x-show="activeTab === 'about'" x-cloak>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tentang Saya</h3>
                <div class="space-y-4 max-w-2xl">
                    <div>
                        <label for="about_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="about_name" id="about_name" value="{{ $raw['about_name'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="about_bio" class="block text-sm font-medium text-gray-700 mb-1">Bio / Deskripsi</label>
                        <textarea name="about_bio" id="about_bio" rows="5" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ $raw['about_bio'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label for="about_photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                        @if ($raw['about_photo'] ?? null)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $raw['about_photo']) }}" alt="Foto Profil" class="w-24 h-24 rounded-lg object-cover">
                        </div>
                        @endif
                        <input type="file" name="about_photo" id="about_photo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, atau WebP. Maks 2MB.</p>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="about_experience_years" class="block text-sm font-medium text-gray-700 mb-1">Tahun Pengalaman</label>
                            <input type="number" name="about_experience_years" id="about_experience_years" value="{{ $raw['about_experience_years'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>
                        <div>
                            <label for="about_projects_count" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Proyek</label>
                            <input type="number" name="about_projects_count" id="about_projects_count" value="{{ $raw['about_projects_count'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>
                        <div>
                            <label for="about_clients_count" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Klien</label>
                            <input type="number" name="about_clients_count" id="about_clients_count" value="{{ $raw['about_clients_count'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>
                    </div>

                    {{-- 🌐 English Translation --}}
                    <div class="border-l-4 border-blue-400 pl-4 space-y-4 mt-6">
                        <h4 class="text-sm font-semibold text-blue-700">🌐 English Translation</h4>
                        <div>
                            <label for="en_about_name" class="block text-sm font-medium text-blue-600 mb-1">Full Name (EN)</label>
                            <input type="text" name="en[about_name]" id="en_about_name" value="{{ $rawEn['about_name'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="e.g. John Doe">
                        </div>
                        <div>
                            <label for="en_about_bio" class="block text-sm font-medium text-blue-600 mb-1">Bio / Description (EN)</label>
                            <textarea name="en[about_bio]" id="en_about_bio" rows="5" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="English bio...">{{ $rawEn['about_bio'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab: Contact --}}
            <div x-show="activeTab === 'contact'" x-cloak>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kontak & Social Media</h3>
                <div class="space-y-4 max-w-2xl">
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ $raw['contact_email'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" name="contact_phone" id="contact_phone" value="{{ $raw['contact_phone'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="081234567890">
                    </div>
                    <div>
                        <label for="contact_whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp (tanpa +, contoh: 6281234567890)</label>
                        <input type="text" name="contact_whatsapp" id="contact_whatsapp" value="{{ $raw['contact_whatsapp'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="contact_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea name="contact_address" id="contact_address" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ $raw['contact_address'] ?? '' }}</textarea>
                    </div>
                    <hr class="my-4">
                    <h4 class="text-sm font-semibold text-gray-700">Social Media</h4>
                    <div>
                        <label for="contact_github" class="block text-sm font-medium text-gray-700 mb-1">GitHub URL</label>
                        <input type="url" name="contact_github" id="contact_github" value="{{ $raw['contact_github'] ?? '' }}" placeholder="https://github.com/username" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="contact_linkedin" class="block text-sm font-medium text-gray-700 mb-1">LinkedIn URL</label>
                        <input type="url" name="contact_linkedin" id="contact_linkedin" value="{{ $raw['contact_linkedin'] ?? '' }}" placeholder="https://linkedin.com/in/username" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="contact_instagram" class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                        <input type="url" name="contact_instagram" id="contact_instagram" value="{{ $raw['contact_instagram'] ?? '' }}" placeholder="https://instagram.com/username" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                </div>
            </div>

            {{-- Tab: General --}}
            <div x-show="activeTab === 'general'" x-cloak>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Umum</h3>
                <div class="space-y-4 max-w-2xl">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Website</label>
                        <input type="text" name="site_name" id="site_name" value="{{ $raw['site_name'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Website (SEO)</label>
                        <textarea name="site_description" id="site_description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ $raw['site_description'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label for="footer_text" class="block text-sm font-medium text-gray-700 mb-1">Teks Footer</label>
                        <input type="text" name="footer_text" id="footer_text" value="{{ $raw['footer_text'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>

                    {{-- 🌐 English Translation --}}
                    <div class="border-l-4 border-blue-400 pl-4 space-y-4 mt-6">
                        <h4 class="text-sm font-semibold text-blue-700">🌐 English Translation</h4>
                        <div>
                            <label for="en_site_description" class="block text-sm font-medium text-blue-600 mb-1">Website Description / SEO (EN)</label>
                            <textarea name="en[site_description]" id="en_site_description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="English site description...">{{ $rawEn['site_description'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label for="en_footer_text" class="block text-sm font-medium text-blue-600 mb-1">Footer Text (EN)</label>
                            <input type="text" name="en[footer_text]" id="en_footer_text" value="{{ $rawEn['footer_text'] ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="e.g. All rights reserved.">
                        </div>
                    </div>

                    <div>
                        <label for="site_logo" class="block text-sm font-medium text-gray-700 mb-1">Logo Website</label>
                        @if ($raw['site_logo'] ?? null)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $raw['site_logo']) }}" alt="Logo" class="h-10">
                        </div>
                        @endif
                        <input type="file" name="site_logo" id="site_logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                    <div>
                        <label for="site_favicon" class="block text-sm font-medium text-gray-700 mb-1">Favicon</label>
                        @if ($raw['site_favicon'] ?? null)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $raw['site_favicon']) }}" alt="Favicon" class="h-8 w-8">
                        </div>
                        @endif
                        <input type="file" name="site_favicon" id="site_favicon" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl flex justify-end">
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection