<header class="app-header" class="justify-content-between">
  <div class="app-header-logo">
    <div class="logo">
				<span class="logo-icon">
{{--					<img src="https://assets.codepen.io/285131/almeria-logo.svg"/>--}}
				</span>
      <h1 class="logo-title">
        <span>Almeria</span>
        <span>NeoBank</span>
      </h1>
    </div>
  </div>
  @auth()
    <div class="app-header-actions">
      <div class="dropdown">
        <div class="dropdown">
          <button
            class="btn btn-secondary user-profile dropdown-toggle"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <span>{{auth()->user()->name}}</span>
            <span>
              <img src="https://assets.codepen.io/285131/almeria-avatar.jpeg"/>
            </span>
          </button>
          <ul class="dropdown-menu">
            <li>
              <form action="{{ url('logout') }}" method="POST">
                @csrf
                <button class="dropdown-item" type="submit">Выйти</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
      <div class="app-header-actions-buttons">
        <button class="icon-button large">
          <i class="ph-magnifying-glass"></i>
        </button>
        <button class="icon-button large">
          <i class="ph-bell"></i>
        </button>
      </div>
    </div>
    <div class="app-header-mobile">
      <button class="icon-button large">
        <i class="ph-list"></i>
      </button>
    </div>
  @endauth
</header>