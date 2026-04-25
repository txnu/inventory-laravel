<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login - Inventory</title>
		<link rel="preconnect" href="https://fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
		<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

		@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
			@vite(['resources/css/app.css', 'resources/js/app.js'])
		@endif
	</head>

	<body class="min-h-screen bg-slate-950 text-slate-100">
		<div class="min-h-screen flex items-center justify-center px-4 py-10">
			<div
				class="w-full max-w-6xl overflow-hidden rounded-[2rem] border border-slate-800 shadow-2xl shadow-slate-900/40 bg-slate-900/95 md:grid md:grid-cols-[1.2fr_0.8fr]">

				<div
					class="relative hidden bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.3),_transparent_35%),linear-gradient(180deg,_#0f172a,_#020617)] p-10 text-slate-100 md:block">
					<div
						class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1000&q=80')] bg-cover bg-center opacity-30">
					</div>
					<div class="absolute inset-0 bg-slate-950/85"></div>
					<div class="relative z-10 flex h-full flex-col justify-between gap-6">
						<div>
							<span
								class="inline-flex items-center gap-2 rounded-full bg-emerald-500/15 px-4 py-2 text-sm font-semibold text-emerald-300">Inventory
								Gudang</span>
							<h1 class="mt-8 text-4xl font-semibold tracking-tight text-white">Sistem Gudang & Persediaan</h1>
							<p class="mt-4 max-w-xl text-slate-300">Kelola stok, penerimaan, pesanan pembelian, dan laporan gudang dalam satu
								platform yang rapi dan responsif.</p>
						</div>
						<div class="space-y-4 text-sm text-slate-400">
							<div class="rounded-2xl border border-slate-700/60 bg-slate-950/70 p-5">
								<p class="font-semibold text-slate-100">Fitur Utama</p>
								<ul class="mt-3 space-y-2 text-slate-400">
									<li class="flex items-center gap-3"><span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>Manajemen stok
									</li>
									<li class="flex items-center gap-3"><span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>Riwayat
										penerimaan</li>
									<li class="flex items-center gap-3"><span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>Pembelian dan
										supplier</li>
								</ul>
							</div>
							<p>Masuk dengan akun resmi untuk melanjutkan ke dashboard inventory.</p>
						</div>
					</div>
				</div>

				<div class="p-8 sm:p-10">
					<div class="mb-8 flex flex-col gap-2">
						<span class="inline-flex items-center gap-2 text-sm uppercase tracking-[0.3em] text-emerald-400">Masuk</span>
						<h2 class="text-3xl font-semibold text-white">Selamat Datang Kembali</h2>
						<p class="max-w-md text-slate-400">Silakan login untuk mengakses dashboard inventory dan manajemen gudang Anda.
						</p>
					</div>

					@if (session('error'))
						<div class="mb-5 rounded-2xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-100">
							{{ session('error') }}
						</div>
					@endif

					@if ($errors->any())
						<div class="mb-5 rounded-2xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-100">
							<ul class="list-disc list-inside">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form action="{{ route('login.authenticate') }}" method="POST" class="space-y-5">
						@csrf

						<div>
							<label class="mb-2 block text-sm font-medium text-slate-300">Email</label>
							<input type="email" name="email" value="{{ old('email') }}"
								class="w-full rounded-3xl border border-slate-700 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/20"
								placeholder="contoh@domain.com" required autofocus>
						</div>

						<div>
							<label class="mb-2 block text-sm font-medium text-slate-300">Password</label>
							<input type="password" name="password"
								class="w-full rounded-3xl border border-slate-700 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/20"
								placeholder="••••••••" required>
						</div>

						<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
							<label class="inline-flex items-center gap-2 text-sm text-slate-400">
								<input type="checkbox" name="remember"
									class="h-4 w-4 rounded border-slate-700 bg-slate-950 text-emerald-500 focus:ring-emerald-400">
								Ingat saya
							</label>
							<a href="#" class="text-sm font-medium text-emerald-300 hover:text-white">Lupa password?</a>
						</div>

						<button type="submit"
							class="w-full rounded-3xl bg-emerald-500 px-5 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-slate-950 transition hover:bg-emerald-400">Login</button>
					</form>

					<div class="mt-8 rounded-3xl border border-slate-700/70 bg-slate-950/80 p-5 text-sm text-slate-400">
						<p class="font-semibold text-slate-200">Inventory Web</p>
						<p class="mt-2 text-slate-400">Dashboard gudang untuk stok, supplier, purchase order, dan penerimaan.</p>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>
