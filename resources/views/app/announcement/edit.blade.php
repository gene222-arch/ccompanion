@extends('layouts.main')

@section('content')
    <div class="display-6 px-2 py-3">Update Announcement</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('announcements.update', $announcement->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                       <div class="row">
                           <div class="col-12 text-center py-4">
                                <i class="fa-solid fa-newspaper fa-2x text-info"></i>
                           </div>
                           <div class="col-12 text-center">
                                <img 
                                    id="img"
                                    class="img mb-3" 
                                    src="{{ asset('storage/' . $announcement->image_path) }}"
                                    style="width: 30%; height: 15rem; border-radius: 0.5rem;"
                                >
                           </div>
                           <div class="col-12">
                                <div class="form-group text-center">
                                    <input 
                                        type="file" 
                                        name="image" 
                                        class="form-control @error('image') is-invalid @enderror" 
                                        id="chooseFile"
                                        oninput="img.src=window.URL.createObjectURL(this.files[0])"
                                        value="{{ old('image') }}"
                                        style="display: none;"
                                    >
                                    <label for="chooseFile" data-toggle="tooltip" data-placement='left' title="Upload Image">
                                        <div class="btn btn-outline-secondary">
                                            <i class="fa-solid fa-file-image"></i>
                                        </div>
                                    </label>
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                           </div>
                           <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Header</label>
                                    <input 
                                        id="header" 
                                        type="text" 
                                        class="form-control @error('header') is-invalid @enderror" 
                                        placeholder="Enter header" 
                                        name="header"
                                        value="{{ old('header', $announcement->header) }}"
                                    >
                                    @error('header')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                           </div>
                           <div class="col-12">
                                <div class="form-group">
                                    <label for="subheader">Subheader</label>
                                    <input 
                                        id="subheader" 
                                        type="text" 
                                        class="form-control @error('subheader') is-invalid @enderror" 
                                        placeholder="Enter subheader" 
                                        name="subheader"
                                        value="{{ old('subheader', $announcement->subheader) }}"
                                    >
                                    @error('subheader')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="body">Body</label>
                                    <textarea 
                                        id="body" 
                                        class="ckeditor form-control @error('body') is-invalid @enderror" 
                                        name="body"
                                    >{{ old('body', $announcement->body) }}</textarea>
                                    @error('body')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                           <div class="col-12 mt-5 text-right">
                               <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary">Cancel</a>
                               <button type="submit" class="btn btn-success">Save</button>
                           </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
@endsection