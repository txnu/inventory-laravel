<aside x-data
	class="fixed z-30 top-0 inset-y-0 px-3 py-3 h-screen bg-white border-r border-gray-200 overflow-y-auto shadow-lg transition-all duration-300 ease-in-out"
	:class="(sidebarOpen || sidebarHovered) ? 'w-72' : 'w-20'" @mouseenter="sidebarHovered = true"
	@mouseleave="sidebarHovered = false" @toggle-sidebar.window="sidebarOpen = !sidebarOpen">
	<div class="px-4 py-3 flex flex-col overflow-hidden transition-all duration-300">
		<!-- Logo -->
		<img src="{{ asset('images/logo.png') }}" alt="Kedra Template - Kedai Programmer"
			class="w-36 transition-all duration-300" :class="(sidebarOpen || sidebarHovered) ? 'opacity-100' : 'opacity-0'">

		<!-- Text di bawah logo -->
		<p class="text-sm text-gray-500 mt-1 transition-all duration-300 overflow-hidden"
			:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 max-h-6' : 'opacity-0 max-h-0'">
			Inventory Management
		</p>
		<p class="text-sm text-gray-500 mt-1 transition-all duration-300 overflow-hidden"
			:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 max-h-6' : 'opacity-0 max-h-0'">
			by <b>Kedai Programmer Nusantara</b>
		</p>

		<hr class="my-3 border-gray-200 w-full">
	</div>


	<nav class="flex-1 w-full">
		<ul class="space-y-1">
			<!-- Dashboard -->
			<li>
				<a href="{{ route('dashboard') }}"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition group
						{{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-home class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Dashboard
					</span>
				</a>
			</li>

			<!-- Inventory Section -->
			<li class="pt-4 pb-2">
				<span
					class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 overflow-hidden transition-all duration-300"
					:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 max-h-6' : 'opacity-0 hidden max-h-0'">
					Inventory
				</span>
				<hr class="border-gray-200 mx-1 transition-all duration-300"
					:class="(sidebarOpen || sidebarHovered) ? 'opacity-0 hidden max-h-0' : 'opacity-100 max-h-6'">
			</li>

			<!-- Products -->
			<li>
				<a href="{{ route('product.index') }}"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('product.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-fluentui-production-24-o class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Products
					</span>
				</a>
			</li>

			<!-- Categories -->
			<li>
				<a href="{{ route('category.index') }}"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('category.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-c-list-bullet class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Categories
					</span>
				</a>
			</li>

			<!-- Stock Adjustments -->
			<li>
				<a href="{{ route('stock-adjustment.index') }}"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('stock-adjustment.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-adjustments-horizontal class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Stock Adjustments
					</span>
				</a>
			</li>

			<!-- Stock Movements -->
			<li>
				<a href="{{ route('stock-movement.index') }}"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('stock-movement.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-arrows-right-left class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Stock Movements
					</span>
				</a>
			</li>

			<!-- Stock -->
			<li>
				<a href="{{ route('stock.index') }}"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('stock.index') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-cube class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Stocks
					</span>
				</a>
			</li>


			<!-- Warehouses -->
			<li>
				<a href="{{ route('warehouse.index') }}"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('warehouse.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-s-cube-transparent class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Warehouses
					</span>
				</a>
			</li>

			<!-- Transactions Section -->
			<li class="pt-4 pb-2">
				<span
					class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 overflow-hidden transition-all duration-300"
					:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 max-h-6' : 'opacity-0 hidden max-h-0'">
					Transactions
				</span>
				<hr class="border-gray-200 mx-1 transition-all duration-300"
					:class="(sidebarOpen || sidebarHovered) ? 'opacity-0 hidden max-h-0' : 'opacity-100 max-h-6'">
			</li>

			<!-- Purchase Orders -->
			<li>
				<a href="{{ route('purchase-order.index') }}"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('purchase-order.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-shopping-cart class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Purchase Orders
					</span>
				</a>
			</li>

			<!-- Purchase Orders -->
			<li>
				<a href="{{ route('purchase-receiving.index') }}"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('purchase-receiving.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-shopping-cart class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Purchase Receivings
					</span>
				</a>
			</li>

			<!-- Sales Orders -->
			<li>
				<a href="#"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('sales-orders.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-receipt-percent class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Sales Orders
					</span>
				</a>
			</li>

			<!-- Partners Section -->
			<li class="pt-4 pb-2">
				<span
					class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 overflow-hidden transition-all duration-300"
					:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 max-h-6' : 'opacity-0 hidden max-h-0'">
					Partners
				</span>
				<hr class="border-gray-200 mx-1 transition-all duration-300"
					:class="(sidebarOpen || sidebarHovered) ? 'opacity-0 hidden max-h-0' : 'opacity-100 max-h-6'">
			</li>

			<!-- Suppliers -->
			<li>
				<a href="{{ route('supplier.index') }}"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('supplier.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-truck class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Suppliers
					</span>
				</a>
			</li>

			<!-- Customers -->
			<li>
				<a href="{{ route('customer.index') }}"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('customer.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-user-group class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Customers
					</span>
				</a>
			</li>

			<!-- Reports Section -->
			<li class="pt-4 pb-2">
				<span
					class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 overflow-hidden transition-all duration-300"
					:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 max-h-6' : 'opacity-0 hidden max-h-0'">
					Reports
				</span>
				<hr class="border-gray-200 mx-1 transition-all duration-300"
					:class="(sidebarOpen || sidebarHovered) ? 'opacity-0 hidden max-h-0' : 'opacity-100 max-h-6'">
			</li>

			<!-- Inventory Report -->
			<li>
				<a href="#"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('reports.inventory') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-chart-bar class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Inventory Reports
					</span>
				</a>
			</li>

			<!-- Sales Report -->
			<li>
				<a href="#"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('reports.sales') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-currency-dollar class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Sales Reports
					</span>
				</a>
			</li>

			<!-- Purchase Report -->
			<li>
				<a href="#"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('reports.purchase') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-document-chart-bar class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Purchase Report
					</span>
				</a>
			</li>

			<!-- Settings Section -->
			<li class="pt-4 pb-2">
				<span
					class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 overflow-hidden transition-all duration-300"
					:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 max-h-6' : 'opacity-0 hidden max-h-0'">
					Settings
				</span>
				<hr class="border-gray-200 mx-1 transition-all duration-300"
					:class="(sidebarOpen || sidebarHovered) ? 'opacity-0 hidden max-h-0' : 'opacity-100 max-h-6'">
			</li>

			<!-- Users -->
			<li>
				<a href="#"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-far-user class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Users
					</span>
				</a>
			</li>

			<!-- Units -->
			<li>
				<a href="#"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('units.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-scale class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Units
					</span>
				</a>
			</li>

			<!-- Audit Logs -->
			<li>
				<a href="#"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition
                           {{ request()->routeIs('audit-logs.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
					<x-heroicon-o-clipboard-document-list class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Audit Log
					</span>
				</a>
			</li>
		</ul>

		<!-- Logout -->
		<div class="mt-8 pt-4 border-t border-gray-200">
			<form method="POST" action="#">
				@csrf
				<button type="submit"
					class="flex items-center gap-4 text-base px-3 py-2.5 rounded-lg transition text-red-600 hover:bg-red-50 w-full">
					<x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5 min-w-[20px]" />
					<span class="whitespace-nowrap overflow-hidden transition-all duration-300"
						:class="(sidebarOpen || sidebarHovered) ? 'opacity-100 w-auto' :
						'opacity-0 w-0 group-hover:opacity-100 group-hover:w-auto'">
						Logout
					</span>
				</button>
			</form>
		</div>
	</nav>
</aside>
