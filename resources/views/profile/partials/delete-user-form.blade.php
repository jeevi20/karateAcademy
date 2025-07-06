<section class="mb-5">
    <header class="mb-3">
        <h2 class="h4 text-dark">
            {{ __('Delete Account') }}
        </h2>
        <p class="text-muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <!-- Trigger Delete Modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        {{ __('Delete Account') }}
    </button>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade @if ($errors->userDeletion->isNotEmpty()) show d-block @endif" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true" @if ($errors->userDeletion->isNotEmpty()) style="background-color: rgba(0,0,0,.5);" @endif>
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUserDeletionLabel">{{ __('Are you sure you want to delete your account?') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p>
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" id="password" name="password" placeholder="{{ __('Password') }}"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror">
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <!-- <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
