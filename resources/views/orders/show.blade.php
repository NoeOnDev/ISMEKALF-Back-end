<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle de Remisión #') . $order->remission_number }}
            </h2>
            <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-6">
                        <div class="mb-4 md:mb-0">
                            <h3 class="text-lg font-semibold">Información de Remisión</h3>
                            <p class="mt-2"><span class="font-semibold">Número:</span> {{ $order->remission_number }}</p>
                            <p><span class="font-semibold">Estado:</span>
                                @if($order->status == 'completed')
                                    <span class="text-green-600">Completada</span>
                                @else
                                    <span class="text-red-600">Cancelada</span>
                                @endif
                            </p>
                            <p><span class="font-semibold">Fecha:</span> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            <p><span class="font-semibold">Creado por:</span> {{ $order->creator->name }}</p>
                            @if($order->notes)
                                <p class="mt-2"><span class="font-semibold">Notas:</span> {{ $order->notes }}</p>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">Datos del Cliente</h3>
                            <p><span class="font-semibold">Nombre:</span> {{ $order->client->name }}</p>
                            <p><span class="font-semibold">Código:</span> {{ $order->client->code }}</p>
                            @if($order->client->contact)
                                <p><span class="font-semibold">Contacto:</span> {{ $order->client->contact }}</p>
                            @endif
                            @if($order->client->phone)
                                <p><span class="font-semibold">Teléfono:</span> {{ $order->client->phone }}</p>
                            @endif
                            @if($order->client->version)
                                <p><span class="font-semibold">Versión:</span> {{ $order->client->version }}</p>
                            @endif
                            @if($order->client->address)
                                <p><span class="font-semibold">Dirección:</span> {{ $order->client->address }}</p>
                            @endif
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Productos Remitidos</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marca</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->product->model }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $item->product->brand->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $item->product->location ?? 'N/A' }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($order->status === 'completed' && Auth::user()->hasRole('administrador'))
                        <div class="mt-6 flex justify-end">
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('¿Está seguro de cancelar esta remisión? Esta acción revertirá el inventario.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Cancelar Remisión
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
