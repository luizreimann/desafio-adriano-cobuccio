<section>
    <h2 class="h5">Atualizar Senha</h2>
    <p class="text-muted mb-4">
        Use uma senha longa e aleatória para manter sua conta segura.
    </p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="current_password" class="form-label">Senha Atual</label>
            <input id="current_password" name="current_password" type="password" class="form-control" required autocomplete="current-password">
            @if ($errors->updatePassword->get('current_password'))
                <div class="text-danger mt-1">
                    {{ $errors->updatePassword->first('current_password') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nova Senha</label>
            <input id="password" name="password" type="password" class="form-control" required autocomplete="new-password">
            @if ($errors->updatePassword->get('password'))
                <div class="text-danger mt-1">
                    {{ $errors->updatePassword->first('password') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required autocomplete="new-password">
            @if ($errors->updatePassword->get('password_confirmation'))
                <div class="text-danger mt-1">
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-warning">Salvar</button>

            @if (session('status') === 'password-updated')
                <span class="text-success small">Senha atualizada com sucesso.</span>
            @endif
        </div>
    </form>
</section>
