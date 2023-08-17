@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        Add New Species
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <label for="species_id" class="col-form-label text-md-end">{{ __('Species ID') }}</label>

                                <div class="col-md-12">
                                    <input id="species_id" type="text"
                                        class="form-control @error('species_id') is-invalid @enderror" name="species_id"
                                        value="{{ old('species_id') }}" required autocomplete="species_id" autofocus>

                                    @error('species_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-8">
                                <label for="name" class="col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-12">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col">
                                <label for="kingdom" class="col-form-label text-md-end">{{ __('Kingdom') }}</label>

                                <div class="col-md-12">
                                    <input id="kingdom" type="text"
                                        class="form-control @error('kingdom') is-invalid @enderror" name="kingdom"
                                        value="{{ old('kingdom') }}" required autocomplete="kingdom" autofocus>

                                    @error('kingdom')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <label for="phylum" class="col-form-label text-md-end">{{ __('Phylum') }}</label>

                                <div class="col-md-12">
                                    <input id="phylum" type="text"
                                        class="form-control @error('phylum') is-invalid @enderror" name="phylum"
                                        value="{{ old('name') }}" required autocomplete="phylum" autofocus>

                                    @error('phylum')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <label for="class" class="col-form-label text-md-end">{{ __('Class') }}</label>

                                <div class="col-md-12">
                                    <input id="class" type="text"
                                        class="form-control @error('class') is-invalid @enderror" name="class"
                                        value="{{ old('name') }}" required autocomplete="class" autofocus>

                                    @error('class')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <label for="order" class="col-form-label text-md-end">{{ __('Order') }}</label>

                                <div class="col-md-12">
                                    <input id="order" type="text"
                                        class="form-control @error('order') is-invalid @enderror" name="order"
                                        value="{{ old('name') }}" required autocomplete="order" autofocus>

                                    @error('order')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <label for="family" class="col-form-label text-md-end">{{ __('Family') }}</label>

                                <div class="col-md-12">
                                    <input id="family" type="text"
                                        class="form-control @error('family') is-invalid @enderror" name="family"
                                        value="{{ old('name') }}" required autocomplete="family" autofocus>

                                    @error('family')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <label for="genus" class="col-form-label text-md-end">{{ __('Genus') }}</label>

                                <div class="col-md-12">
                                    <input id="genus" type="text"
                                        class="form-control @error('genus') is-invalid @enderror" name="genus"
                                        value="{{ old('name') }}" required autocomplete="genus" autofocus>

                                    @error('genus')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="species" class="col-form-label text-md-end">{{ __('Species') }}</label>

                                <div class="col-md-12">
                                    <input id="species" type="text"
                                        class="form-control @error('species') is-invalid @enderror" name="species"
                                        value="{{ old('species') }}" required autocomplete="species" autofocus>

                                    @error('species')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <label for="common_name"
                                    class="col-form-label text-md-end">{{ __('Common Name') }}</label>

                                <div class="col-md-12">
                                    <input id="common_name" type="text"
                                        class="form-control @error('common_name') is-invalid @enderror" name="common_name"
                                        value="{{ old('common_name') }}" required autocomplete="common_name" autofocus>

                                    @error('common_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <label for="local_name" class="col-form-label text-md-end">{{ __('Local Name') }}</label>

                                <div class="col-md-12">
                                    <input id="local_name" type="text"
                                        class="form-control @error('local_name') is-invalid @enderror" name="local_name"
                                        value="{{ old('local_name') }}" required autocomplete="local_name" autofocus>

                                    @error('local_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="country" class="col-form-label text-md-end">{{ __('Country') }}</label>

                                <div class="col-md-12">
                                    <input id="country" type="text"
                                        class="form-control @error('country') is-invalid @enderror" name="country"
                                        value="{{ old('country') }}" required autocomplete="country" autofocus>

                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <label for="environment"
                                    class="col-form-label text-md-end">{{ __('Environment') }}</label>

                                <div class="col-md-12">
                                    <input id="environment" type="text"
                                        class="form-control @error('environment') is-invalid @enderror"
                                        name="environment" value="{{ old('environment') }}" required
                                        autocomplete="environment" autofocus>

                                    @error('environment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="general_description"
                                    class="col-form-label text-md-end">{{ __('General Description') }}</label>

                                <div class="col-md-12">
                                    <input id="general_description" type="text"
                                        class="form-control @error('general_description') is-invalid @enderror"
                                        name="general_description" value="{{ old('general_description') }}" required
                                        autocomplete="general_description" autofocus>

                                    @error('general_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="iucn_status"
                                    class="col-form-label text-md-end">{{ __('IUCN Status') }}</label>

                                <div class="col-md-12">
                                    <input id="iucn_status" type="text"
                                        class="form-control @error('iucn_status') is-invalid @enderror"
                                        name="iucn_status" value="{{ old('iucn_status') }}" required
                                        autocomplete="iucn_status" autofocus>

                                    @error('iucn_status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="threats_to_humans"
                                    class="col-form-label text-md-end">{{ __('Threats to humans') }}</label>

                                <div class="col-md-12">
                                    <input id="threats_to_humans" type="text"
                                        class="form-control @error('threats_to_humans') is-invalid @enderror"
                                        name="threats_to_humans" value="{{ old('threats_to_humans') }}" required
                                        autocomplete="threats_to_humans" autofocus>

                                    @error('threats_to_humans')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <label for="economic_value_uses"
                                    class="col-form-label text-md-end">{{ __('Economic Value Uses') }}</label>

                                <div class="col-md-12">
                                    <input id="economic_value_uses" type="text"
                                        class="form-control @error('economic_value_uses') is-invalid @enderror"
                                        name="economic_value_uses" value="{{ old('economic_value_uses') }}" required
                                        autocomplete="economic_value_uses" autofocus>

                                    @error('economic_value_uses')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="references" class="col-form-label text-md-end">{{ __('References') }}</label>

                                <div class="col-md-12">
                                    <textarea id="references" type="text"
                                        class="form-control @error('references') is-invalid @enderror" name="references"
                                        value="{{ old('references') }}" required autocomplete="references" autofocus>
                                    </textarea>

                                    @error('references')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
