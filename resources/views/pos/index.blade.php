<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800">
                {{ __('Minimarket (Punto de Venta)') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6" x-data="posApp()">
        <div class="mx-auto max-w-[1600px] sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 lg:flex-row">
                
                {{-- Lado Izquierdo: Catálogo de Productos --}}
                <div class="flex-1 rounded-2xl bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Catálogo de Productos</h3>
                        <input type="text" x-model="search" placeholder="Buscar producto..." class="rounded-lg border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5">
                        <template x-for="producto in filteredProductos" :key="producto.id">
                            <button @click="addToCart(producto)" class="relative flex h-32 flex-col items-center justify-center overflow-hidden rounded-xl border border-gray-100 bg-slate-50 p-3 shadow-sm transition-all hover:-translate-y-1 hover:border-blue-300 hover:bg-blue-50 hover:shadow-md focus:outline-none">
                                <span class="mb-2 text-xs font-semibold uppercase tracking-wider text-blue-600" x-text="producto.categoria"></span>
                                <span class="text-center text-sm font-bold leading-tight text-gray-900 line-clamp-2" x-text="producto.nombre"></span>
                                <span class="mt-auto text-lg font-black text-emerald-600" x-text="'$' + parseFloat(producto.precio_venta).toFixed(2)"></span>
                                <div class="absolute right-2 top-2 rounded bg-gray-200 px-1.5 py-0.5 text-[10px] font-bold text-gray-600" x-text="'Stock: ' + producto.stock_actual"></div>
                            </button>
                        </template>
                        <div x-show="filteredProductos.length === 0" class="col-span-full py-8 text-center text-gray-500">
                            No se encontraron productos en stock.
                        </div>
                    </div>
                </div>

                {{-- Lado Derecho: Ticket / Carrito --}}
                <div class="w-full shrink-0 lg:w-[400px]">
                    <div class="sticky top-6 flex flex-col overflow-hidden rounded-2xl bg-white shadow-lg shadow-gray-200/50">
                        <div class="bg-gray-900 px-6 py-4">
                            <h3 class="text-lg font-black tracking-wide text-white">TICKET DE COMPRA</h3>
                        </div>

                        <div class="flex-1 overflow-y-auto p-4" style="max-h: calc(100vh - 350px); min-h: 300px;">
                            <template x-if="cart.length === 0">
                                <div class="flex h-full flex-col items-center justify-center text-gray-400">
                                    <svg class="mb-3 h-12 w-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    <p class="text-sm font-medium">El carrito está vacío</p>
                                </div>
                            </template>

                            <ul class="space-y-3">
                                <template x-for="(item, index) in cart" :key="item.id">
                                    <li class="flex items-center justify-between rounded-lg border border-gray-100 bg-slate-50 p-3 shadow-sm">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-bold text-gray-900 line-clamp-1" x-text="item.nombre"></h4>
                                            <p class="text-xs font-medium text-emerald-600" x-text="'$' + parseFloat(item.precio_venta).toFixed(2) + ' c/u'"></p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center rounded-lg border border-gray-200 bg-white shadow-sm">
                                                <button @click="decreaseQty(index)" class="px-2 py-1 text-gray-500 hover:text-red-500">-</button>
                                                <span class="w-8 text-center text-sm font-bold text-gray-900" x-text="item.cantidad"></span>
                                                <button @click="increaseQty(index)" class="px-2 py-1 text-gray-500 hover:text-blue-500">+</button>
                                            </div>
                                            <div class="w-16 text-right">
                                                <span class="text-sm font-black text-gray-900" x-text="'$' + (item.cantidad * item.precio_venta).toFixed(2)"></span>
                                            </div>
                                            <button @click="removeFromCart(index)" class="text-gray-400 hover:text-red-500">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <div class="border-t border-gray-100 bg-gray-50 p-6">
                            <div class="mb-4 flex items-center justify-between">
                                <span class="text-sm font-bold text-gray-500 uppercase">Total a Pagar</span>
                                <span class="text-4xl font-black text-blue-600" x-text="'$' + totalCart.toFixed(2)"></span>
                            </div>

                            <div class="mb-4 grid grid-cols-2 gap-2">
                                <button @click="metodoPago = 'efectivo'" :class="metodoPago === 'efectivo' ? 'bg-blue-100 border-blue-500 text-blue-700' : 'bg-white border-gray-200 text-gray-600'" class="rounded-lg border py-2 text-sm font-bold shadow-sm transition-colors">EFECTIVO</button>
                                <button @click="metodoPago = 'tarjeta'" :class="metodoPago === 'tarjeta' ? 'bg-blue-100 border-blue-500 text-blue-700' : 'bg-white border-gray-200 text-gray-600'" class="rounded-lg border py-2 text-sm font-bold shadow-sm transition-colors">TARJETA</button>
                            </div>

                            <button 
                                @click="checkout()" 
                                :disabled="cart.length === 0 || isProcessing"
                                class="flex w-full items-center justify-center rounded-xl bg-emerald-500 px-4 py-4 text-lg font-black text-white shadow-lg shadow-emerald-500/30 transition-all hover:bg-emerald-600 disabled:opacity-50 disabled:shadow-none"
                            >
                                <span x-show="!isProcessing">COBRAR TICKET</span>
                                <span x-show="isProcessing" class="flex items-center gap-2">
                                    <svg class="h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    PROCESANDO...
                                </span>
                            </button>

                            <!-- Mensaje de error/exito -->
                            <div x-show="message" class="mt-3 rounded p-2 text-center text-sm font-bold" :class="isError ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'" x-text="message" style="display: none;"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function posApp() {
            return {
                productos: @json($productos),
                search: '',
                cart: [],
                metodoPago: 'efectivo',
                isProcessing: false,
                message: '',
                isError: false,

                get filteredProductos() {
                    if (this.search === '') {
                        return this.productos;
                    }
                    return this.productos.filter(p => p.nombre.toLowerCase().includes(this.search.toLowerCase()) || p.categoria.toLowerCase().includes(this.search.toLowerCase()));
                },

                get totalCart() {
                    return this.cart.reduce((total, item) => total + (item.precio_venta * item.cantidad), 0);
                },

                addToCart(producto) {
                    const existingIndex = this.cart.findIndex(item => item.id === producto.id);
                    if (existingIndex !== -1) {
                        if (this.cart[existingIndex].cantidad < producto.stock_actual) {
                            this.cart[existingIndex].cantidad++;
                        } else {
                            this.showMessage('Stock máximo alcanzado para este producto.', true);
                        }
                    } else {
                        this.cart.push({
                            ...producto,
                            cantidad: 1
                        });
                    }
                },

                increaseQty(index) {
                    const item = this.cart[index];
                    const originalProduct = this.productos.find(p => p.id === item.id);
                    if (item.cantidad < originalProduct.stock_actual) {
                        item.cantidad++;
                    }
                },

                decreaseQty(index) {
                    if (this.cart[index].cantidad > 1) {
                        this.cart[index].cantidad--;
                    } else {
                        this.removeFromCart(index);
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },

                showMessage(msg, isErr = false) {
                    this.message = msg;
                    this.isError = isErr;
                    setTimeout(() => { this.message = ''; }, 3000);
                },

                checkout() {
                    if (this.cart.length === 0) return;
                    this.isProcessing = true;

                    fetch('{{ route('pos.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            carrito: this.cart,
                            metodo_pago: this.metodoPago
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.isProcessing = false;
                        if (data.success) {
                            this.showMessage('Venta registrada con éxito (Ticket #' + data.venta_id + ')', false);
                            // Actualizar stock localmente para no recargar la pagina
                            this.cart.forEach(item => {
                                const prod = this.productos.find(p => p.id === item.id);
                                if(prod) prod.stock_actual -= item.cantidad;
                            });
                            // Filtrar los que llegaron a 0
                            this.productos = this.productos.filter(p => p.stock_actual > 0);
                            this.cart = [];
                        } else {
                            this.showMessage(data.message || 'Error al procesar.', true);
                        }
                    })
                    .catch(err => {
                        this.isProcessing = false;
                        this.showMessage('Error de conexión.', true);
                    });
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
