@extends('layouts.main')

@section('content')
    <div class="display-6 px-2 py-3">Create Announcement</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('announcements.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                       <div class="row">
                           <div class="col-12 text-center py-4">
                                <i class="fa-solid fa-newspaper fa-2x text-info"></i>
                           </div>
                           <div class="col-12 text-center">
                                <img 
                                    id="img"
                                    class="img mb-3" 
                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAANlBMVEX///+/v7+8vLzKysr8/Pzg4ODFxcXb29vT09Pj4+P4+PjBwcH6+vry8vLY2NjIyMjs7Ozo6Oia8u11AAAEdUlEQVR4nO2d65bqIAxGp/Smrb34/i971KqlEC7FGuJZ3/7dKewJBgK4/PsDAAAAAAAAAAAAAAAA4KUam5+i3m94UsUPoVoYwlA6MIShfGAIQ/nAEIbyOcBQSeNww9NZGOXBhuq8+w1fxugfDG1gmB0YBoFhdmAYBIbZgWEQGGYHhkFgmB0YBoFhdmAYBIbZyWB4qVI6mgyv4WUeH7u007lL7vFeWA3n8rUFrZqWK5KchnWvPapOTGFkNDQPOJrhk45Hw2d4Ns+oVPlRz2NhMxyawkTtv2OWAJvhSBwzfjBO2+g/5TLs7BDeSF4eDP0Y+yiX4UydFKtT4pRxa3SKTcVchtQgLYrobhq0Kj7+XIb0aX+fZtipHfH/ScPlZZG5Jq9hk2RYP96lTnFPcxnWpGF52d2eNrPGPc5lOJC5NDrl65Sv1fs16nEuw8v20sdCP+9uTh8NZVSuYVvTnKlBmjAdaqu/uH8Qm2FVWuNUJYSwOu3tLV9tcelNw5SF9yZjRaVixvpwbrZRTKnyuyKysRXOGn/QBqpK25QzptVm9598eyfqXDaPnah+GlNmwr/aGOcqYl3DvJtYzXU7jvU1bbVmVdExE+pP7Qjb6TiiOBFmOPuyD7XyC+djWYadGt2KxE5PzMpWluHtXc6KQZ/rNYK5RpThfWXnrGzp6iRcQ0ky7KbHK+iBup3rtQZD6wZJhq+9HDIsri89BBsUZPguIal0Y871K6ECRY6hXkFaimQeXQjVUHIMNwWkuVax5/q1xcC6Rozh0G+7vYmidaqzCaJ/whBjaEZJr608Y7QIHvBIMbR3/dfB55jr3/hrKCGGxMHN+vmi53rtSW+uEWLYUj1/dsY1169tetc1MgwHaw9HU3TN9Svec0huw4os6CZHcO7dcc/163O+XMNteC0JRfdk0Aby6BNfDcW9i1EquzedI4R36vAYLfy5htnwtnBRvaHo/SZxjN8Nz7UO5ltf97WnMgbqHCfhRbmHKa/hdXl2qxjzQQsaunMNr+FzUlD62W8bORD9TM4gshpe3xVg+Z7BonJlmN55mMhpWGkV4GughtacsbgvLnAa6hXga6B666I9OGsoRsPtMbCa7l2q6OVaAs6uMxpejXDdd+SPSTMP+vyGdri6+bAQui8u8BmaIbwxUdcXkg0dNRTjOf6BNiSOGirrXYxjcXQ+632ag6EPE7kMiU/h4dA1FJfhgUnTzZTRkCOEt8apYcpj+P1E6u4+j+H3E+kCdUmKxZAjkS4QrbMY8nwKC7qGYjFkSaQL9rqGw5AthORhIoMhUyJ9ksPwsDI+Brv97xtWY8mJNUwZYtixYu0qyjhd+yYwDALD7MAwCAyzA8MgMMwODIPAMDtHGxZ1JYvjDRvWajCC7SYRfhsBhvKBIQzlA0MYygeGMJQPDGEoHxjCUD4whKF8YAhD+cAQhvKBIQzlA0MYygeGMJQPDGEoHxjCUD4whKF8YAhD+cAQhvJJM/wpEgyv9U+R8iNaAAAAAAAAAAAAAAAAAP4r/gEYCYE2Xwz6DQAAAABJRU5ErkJggg=="
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
                                        value="{{ old('header') }}"
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
                                        value="{{ old('subheader') }}"
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
                                    >{{ old('body') }}</textarea>
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