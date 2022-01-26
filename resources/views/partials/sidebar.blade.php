<div class="d-flex flex-column flex-shrink-0 p-3 text-white" style="background: linear-gradient(180deg, rgba(37,105,75,1) 0%, rgba(25,51,40,1) 100%); width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4">{{strtok(Auth::user()->full_name, " ")}}</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
		<li class="nav-item">
			<a href="/dashboard" class="nav-link text-white" aria-current="page">
				🏠 Home
			</a>
		</li>
		<li>
			<a href="/news" class="nav-link text-white">
				📰 News
			</a>
		</li>
		<li>
			<a href="/orders" class="nav-link text-white">
				🎖️ Orders
			</a>
		</li>
		<li>
			<a href="/join" class="nav-link text-white">
				🪖 Join
			</a>
		</li>
		<li>
			<a href="/vote" class="nav-link text-white">
				🗳️ Vote
			</a>
		</li>
  </ul>
</div>
