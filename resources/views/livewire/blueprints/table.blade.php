<x-architect::components.card class="flex justify-between">
    <h2 class="text-xl font-semibold">{{ $title }}</h2>
    <div class="flex justify-end items-center space-x-2">

    </div>
</x-architect::components.card>

<x-architect::components.card class="mt-8">
    <x-architect::components.table>
        <tr>
            @foreach($headers as $header)
                <x-architect::components.table.thead>
                    {{ $header }}
                </x-architect::components.table.thead>
            @endforeach
        </tr>

        @foreach($data as $row)
            <tr>
                @foreach($columns as $column)
                    <x-architect::components.table.tcell>
                        {!! $row->$column !!}
                    </x-architect::components.table.tcell>
                @endforeach
            </tr>
        @endforeach
    </x-architect::components.table>
</x-architect::components.card>
