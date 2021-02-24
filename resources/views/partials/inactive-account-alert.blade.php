@auth
    @if(! Auth::user()->hasVerifiedEmail())
        <div class="alert alert-secondary text-center" role="alert">
            Your account is inactive. Please check your email for a verification link.
            If you did not receive the email,
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
            </form>
        </div>
    @endif
@endauth
