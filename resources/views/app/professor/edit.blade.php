@extends('layouts.main')

@section('content')
    <div class="display-6 px-2 py-3">Update Professor</div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('professors.update', $professor->id) }}" method="post">
                @csrf
                @method('PUT')
               <div class="row">
                    <div class="col-12 text-center mb-3">
                            <i class="fa-solid fa-user-tie text-info fa-3x p-4"></i>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="employment_type">Select Employment Type</label>
                            <select 
                                class="form-control custom-select @error('employment_type') is-invalid @enderror" 
                                id="employment_type" 
                                name="employment_type"
                            >
                                <option value="0">Employment Type</option>
                                @foreach ([
                                    'Full-time Employment',
                                    'Part-time Employment'    
                                ] as $employmentType)
                                    <option 
                                        {{ old('employment_type', $professor->employment_type) == $employmentType ? 'selected' : '' }}
                                        value="{{ $employmentType }}"
                                    >
                                        {{ $employmentType }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employment_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="prefix">Select Prefix</label>
                            <select 
                                class="form-control custom-select @error('prefix') is-invalid @enderror" 
                                id="prefix" 
                                name="prefix"
                            >
                                <option value="0">Prefixes</option>
                                @foreach ([
                                    'Phd.',
                                    'M.A.'    
                                ] as $prefix)
                                    <option 
                                        {{ old('prefix', $professor->prefix) == $prefix ? 'selected' : '' }}
                                        value="{{ $prefix }}"
                                    >
                                        {{ $prefix }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prefix')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input 
                                id="first_name" 
                                type="text" 
                                class="form-control @error('first_name') is-invalid @enderror" 
                                placeholder="Enter First Name" 
                                name="first_name"
                                value="{{ old('first_name', $professor->first_name) }}"
                            >
                            @error('first_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input 
                                id="last_name" 
                                type="text" 
                                class="form-control @error('last_name') is-invalid @enderror" 
                                placeholder="Enter Last Name" 
                                name="last_name"
                                value="{{ old('last_name', $professor->last_name) }}"
                            >
                            @error('last_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="birthed_at">Birthday</label>
                            <input 
                                id="birthed_at" 
                                type="date" 
                                class="form-control @error('birthed_at') is-invalid @enderror" 
                                placeholder="Enter Birthday" 
                                name="birthed_at"
                                value="{{ old('birthed_at', \Carbon\Carbon::parse($professor->birthed_at)->format('Y-d-m')) }}"
                            >
                            @error('birthed_at')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="department">Select Department</label>
                            <select 
                                class="form-control custom-select @error('department_id') is-invalid @enderror" 
                                id="department" 
                                name="department_id"
                            >
                                <option value="0">Select department</option>
                                @foreach ($departments as $department)
                                    <option 
                                        {{ old('department_id', $professor->department_id) == $department->id ? 'selected' : '' }}
                                        value="{{ $department->id }}"
                                    >
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="dropdown-divider mt-4"></div>
                    <div class="col-12">
                        <label 
                            for="subjects" 
                            class="my-4 @error('subject_ids') text-danger @enderror"
                        >
                            Select Subjects
                        </label>
                        <ul class="list-group">
                            @foreach ($subjects as $subject)
                                <div class="list-group-item">
                                    <div class="form-check ml-1">
                                        <input 
                                            id="subject{{ $subject->id }}"
                                            name="subject_ids[]" 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            value="{{ $subject->id }}" 
                                            {{ in_array($subject->id, old('subject_ids', $professorSubjects)) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="subject{{ $subject->id }}">
                                           <i class="mr-2">{{ $subject->code }}</i> {{ "{$subject->name} ({$subject->units} units)" }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-12 mt-5 text-right">
                        <a href="{{ route('professors.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection