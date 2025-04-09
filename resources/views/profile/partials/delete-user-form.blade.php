<section>
    <h2 class="h5 text-danger">Excluir Conta</h2>
    <p class="text-muted mb-4">
        Uma vez excluída, todos os seus dados serão permanentemente apagados. Esta ação não poderá ser desfeita.
    </p>

    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <div class="mb-3">
            <label for="password" class="form-label">Confirme sua senha</label>
            <input id="password" name="password" type="password" class="form-control" required>
            @if ($errors->userDeletion->get('password'))
                <div class="text-danger mt-2">
                    {{ $errors->userDeletion->first('password') }}
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-end">
            <a href="#" onclick="window.history.back()" class="btn btn-secondary me-2">Cancelar</a>
            <button type="submit" class="btn btn-danger">Excluir Conta</button>
        </div>
    </form>
</section>
