@extends('layouts.admin')

@section('title', 'Settings')

@section('content')

    <form action="{{ route('admin.settings.general.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

         <div class="col-lg-3 mb-4">
    <div class="settings-sidebar sticky-top" style="top:90px;">
        
        <div class="settings-sidebar-header">
            <i class="bi bi-sliders"></i>
            <span>Settings Panel</span>
        </div>

        <div class="list-group list-group-flush border-0">

            <button type="button"
                class="list-group-item list-group-item-action active"
                data-bs-toggle="tab"
                data-bs-target="#general-tab">
                <i class="bi bi-gear-fill"></i>
                <span>General</span>
            </button>

            <button type="button"
                class="list-group-item list-group-item-action"
                data-bs-toggle="tab"
                data-bs-target="#smtp-tab">
                <i class="bi bi-envelope-fill"></i>
                <span>SMTP</span>
            </button>

            <button type="button"
                class="list-group-item list-group-item-action"
                data-bs-toggle="tab"
                data-bs-target="#seo-tab">
                <i class="bi bi-search"></i>
                <span>SEO</span>
            </button>

        </div>

    </div>
</div>

            <!-- Tab Content -->
            <div class="col-lg-9">

                <div class="tab-content">

                    <!-- General Settings -->
                    <div class="tab-pane fade show active" id="general-tab">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">General Settings</h5>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Site Name</label>
                                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Site Tagline</label>
                                        <input type="text" name="site_tagline"
                                            value="{{ $settings['site_tagline'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="site_email" value="{{ $settings['site_email'] ?? '' }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="site_phone" value="{{ $settings['site_phone'] ?? '' }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Address</label>
                                        <textarea name="site_address" class="form-control" rows="3">{{ $settings['site_address'] ?? '' }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Currency Symbol</label>
                                        <input type="text" name="currency_symbol"
                                            value="{{ $settings['currency_symbol'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Currency Code</label>
                                        <input type="text" name="currency_code"
                                            value="{{ $settings['currency_code'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Free Shipping Threshold</label>
                                        <input type="number" name="free_shipping_threshold"
                                            value="{{ $settings['free_shipping_threshold'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Shipping Charge</label>
                                        <input type="number" name="shipping_charge"
                                            value="{{ $settings['shipping_charge'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Site Logo</label>
                                        <input type="file" name="site_logo" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Site Favicon</label>
                                        <input type="file" name="site_favicon" class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SMTP Settings -->
                    <div class="tab-pane fade" id="smtp-tab">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">SMTP Settings</h5>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Mail Host</label>
                                        <input type="text" name="mail_host"
                                            value="{{ $settings['mail_host'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Mail Port</label>
                                        <input type="number" name="mail_port"
                                            value="{{ $settings['mail_port'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Mail Username</label>
                                        <input type="text" name="mail_username"
                                            value="{{ $settings['mail_username'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Mail Password</label>
                                        <input type="password" name="mail_password"
                                            value="{{ $settings['mail_password'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Encryption</label>
                                        <select name="mail_encryption" class="form-select">
                                            <option value="tls"
                                                {{ ($settings['mail_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>
                                                TLS
                                            </option>

                                            <option value="ssl"
                                                {{ ($settings['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>
                                                SSL
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Mail From Address</label>
                                        <input type="email" name="mail_from_address"
                                            value="{{ $settings['mail_from_address'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Mail From Name</label>
                                        <input type="text" name="mail_from_name"
                                            value="{{ $settings['mail_from_name'] ?? '' }}" class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="tab-pane fade" id="seo-tab">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">SEO Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Meta Title</label>
                                        <input type="text" name="meta_title"
                                            value="{{ $settings['meta_title'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Google Analytics ID</label>
                                        <input type="text" name="google_analytics_id"
                                            value="{{ $settings['google_analytics_id'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Meta Description</label>
                                        <textarea name="meta_description" rows="4" class="form-control">{{ $settings['meta_description'] ?? '' }}</textarea>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Meta Keywords</label>
                                        <textarea name="meta_keywords" rows="3" class="form-control">{{ $settings['meta_keywords'] ?? '' }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Robots</label>
                                        <select name="meta_robots" class="form-select">
                                            <option value="index,follow"
                                                {{ ($settings['meta_robots'] ?? '') == 'index,follow' ? 'selected' : '' }}>
                                                Index, Follow
                                            </option>

                                            <option value="noindex,nofollow"
                                                {{ ($settings['meta_robots'] ?? '') == 'noindex,nofollow' ? 'selected' : '' }}>
                                                No Index, No Follow
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Canonical URL</label>
                                        <input type="url" name="canonical_url"
                                            value="{{ $settings['canonical_url'] ?? '' }}" class="form-control">
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="settings-save-btn">
                        <i class="bi bi-check-circle me-2"></i>
                        Save Settings
                    </button>
                </div>

            </div>

        </div>

    </form>

@endsection
