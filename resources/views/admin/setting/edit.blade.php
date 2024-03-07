@extends('layouts.admin.template-admin')
@section('content-admin')
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">
    <div class="">
        <h2>Edit Setting</h2>
        <div class="card">
            <div class="card-body col-12 col-md-8">
                <form action="{{ route('admin.settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <x-text-input id="history" label="History" type="text" name="history" :value="$setting->history" />
                    <x-text-input id="community_bio" label="Community Bio" type="text" name="community_bio" :value="$setting->community_bio" />
                    <div class="mb-3">
                        <a href="{{ asset($setting->image) }}" style="max-width: 200px; max-height: 150px;">
                            <img src="{{ asset($setting->image) }}" alt="Setting Image" style="max-width: 200px; max-height: 150px;">
                        </a>
                        <x-text-input id="image" label="Image" type="file" name="image" :value="$setting->image" />
                    </div>
                    <div class="mb-3">
                        <a href="{{ asset($setting->video) }}" style="max-width: 100px; max-height: 100px;">
                            <video src="{{ asset($setting->video) }}" alt="Setting Video" style="max-width: 200px; max-height: 100px;" controls>
                                Your browser does not support the video tag.
                            </video>
                        </a>
                        <x-file-input id="video" label="Video" type="file" name="video" :value="$setting->video" />
                    </div>
                    <div class="mb-3">
                        <a href="{{ asset($setting->video1) }}" style="max-width: 100px; max-height: 100px;">
                            <video src="{{ asset($setting->video1) }}" alt="Setting Video" style="max-width: 200px; max-height: 100px;" controls>
                                Your browser does not support the video tag.
                            </video>
                        </a>
                        <x-file-input id="video1" label="Video 1" type="file" name="video1" :value="$setting->video1" />
                    </div>
                    <div class="mb-3">
                        @if($setting->video2)
                            <a href="{{ asset($setting->video2) }}" style="max-width: 100px; max-height: 100px;" target="_blank">
                                <video src="{{ asset($setting->video2) }}" alt="Setting Video" style="max-width: 200px; max-height: 100px;" controls>
                                    Your browser does not support the video tag.
                                </video>
                            </a>
                        @endif
                        <x-file-input id="video2" label="Video 2" type="file" name="video2" :value="$setting->video2" />
                    </div>
                    <x-text-input id="community_structure" label="Community Structure" type="text" name="community_structure" :value="$setting->community_structure" />
                    <x-text-input id="slogan" label="Slogan" type="text" name="slogan" :value="$setting->slogan" />
                    <x-text-input id="community_name" label="Community Name" type="text" name="community_name" :value="$setting->community_name" />
                    <x-text-input id="endpoint" label="Endpoint" type="text" name="endpoint" :value="$setting->endpoint" />
                    <x-text-input id="sender" label="Sender" type="text" name="sender" :value="$setting->sender" />
                    <x-text-input id="api_key" label="Api Key" type="text" name="api_key" :value="$setting->api_key" />
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
