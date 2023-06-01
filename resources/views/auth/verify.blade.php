<x-app-layout>
  <h1 class="text-2xl mt-5 font-bold">Подтверждение Email</h1>

  @if (session('resent'))
    <x-admin.status :status="'На ваш адрес электронной почты была отправлена новая ссылка для подтверждения.'" />
  @endif

  <p>Прежде чем продолжить, пожалуйста, проверьте свой электронный адрес на наличие ссылки для подтверждения.</p>
  <div class="flex flex-row">Если вы не получили электронное письмо,&nbsp;
    <form method="POST" action="{{ route('lk.verification.resend') }}">
      @csrf
      <button
        type="submit"
        class="font-medium underline font-mono text-sky-400"
      >
        нажмите здесь, чтобы запросить другое.
      </button>
    </form>
  </div>
</x-app-layout>