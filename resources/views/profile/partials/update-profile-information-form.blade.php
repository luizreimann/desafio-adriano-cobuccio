<section>
    <h2 class="h5">Informações do Perfil</h2>
    <p class="text-muted mb-4">
        Atualize o nome e o e-mail da sua conta.
    </p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="form-text text-muted mt-2">
                    Seu e-mail ainda não foi verificado.
                    <button form="send-verification" class="btn btn-link p-0 align-baseline">Clique aqui para reenviar o e-mail de verificação.</button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success mt-2">
                        Um novo link de verificação foi enviado para seu e-mail.
                    </div>
                @endif
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">Salvar</button>

            @if (session('status') === 'profile-updated')
                <span class="text-success small ms-3">Salvo com sucesso.</span>
            @endif
        </div>
    </form>
</section>
