@extends('layouts.main')

@section('content')
    <div class="display-6 px-2 py-3">Update Subject</div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('subjects.update', $subject->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                       <div class="row">
                           <div class="col-12 text-center py-4">
                                <i class="fa-solid fa-book text-info fa-2x"></i>
                           </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input 
                                        id="code" 
                                        type="text" 
                                        class="form-control @error('code') is-invalid @enderror" 
                                        placeholder="Enter code" 
                                        name="code"
                                        value="{{ old('code', $subject->code) }}"
                                    >
                                    @error('code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input 
                                            id="name" 
                                            type="text" 
                                            class="form-control @error('name') is-invalid @enderror" 
                                            placeholder="Enter name" 
                                            name="name"
                                            value="{{ old('name', $subject->name) }}"
                                        >
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="units">Units</label>
                                    <input 
                                        id="units" 
                                        type="text" 
                                        class="form-control @error('units') is-invalid @enderror" 
                                        placeholder="Enter units" 
                                        name="units"
                                        value="{{ old('units', $subject->units) }}"
                                    >
                                    @error('units')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 mt-5 text-right">
                                <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection