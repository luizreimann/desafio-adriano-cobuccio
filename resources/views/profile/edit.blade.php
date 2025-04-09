<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold">Meu Perfil</h2>
    </x-slot>

    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-header">Informações do Perfil</div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Atualizar Senha</div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header text-danger">Excluir Conta</div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>