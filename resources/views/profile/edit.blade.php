<x-dash-layout>

    <div class="container py-5">
        {{-- Page Header --}}
        <div class="mb-4">
            <h2 class="fw-bold h4 text-dark">
                {{ __('Profile') }}
            </h2>
        </div>

        <div class="row g-4">
            {{-- Update Profile Information --}}
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        @role('student')
                            @include('profile.partials.update-profile-student-information-form')
                        @endrole
                        @role('supervisor')
                            @include('profile.partials.update-profile-supervisor-information-form')
                        @endrole


                    </div>
                </div>
            </div>

            {{-- Update Password --}}
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Delete User --}}
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dash-layout>
