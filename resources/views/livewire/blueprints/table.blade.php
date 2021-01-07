<div>
    <x-architect::components.card class="flex justify-between">
        <h2 class="text-xl font-semibold">{{ $title }}</h2>
        <div class="flex justify-end items-end space-x-2">
            @if($settings['searchable'])
                <div class="relative mx-4 lg:mx-0">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-300">
                    <i class="fas fa-search"></i>
                </span>

                    <input class="w-64 rounded-md pl-10 pr-4 border border-gray-300 focus:border-gray-500 outline-none"
                           type="search" wire:model="searchText" wire:keyup="runSearch" placeholder="Search...">
                </div>
            @endif

            @if($settings['canAdd'])
                <x-architect::components.link-button size="small" href="./{{ $route }}/add">
                    Add New
                </x-architect::components.link-button>
            @endif
        </div>
    </x-architect::components.card>

    <x-architect::components.table class="mt-4">
        <thead>
        <tr>
            @foreach($headers as $header)
                <x-architect::components.table.thead>
                    {{ $header }}
                </x-architect::components.table.thead>
            @endforeach

            @if($settings['canAdd'])
                    <x-architect::components.table.thead />
            @endif
        </tr>
        </thead>

        <tbody class="bg-white">
        @foreach($currentData as $row)
            <tr>
                @foreach($columns as $column)
                    <x-architect::components.table.tcell>
                        {!! $row->$column !!}
                    </x-architect::components.table.tcell>
                @endforeach

                @if($this->canEditRow($row, auth()->user()))
                    <x-architect::components.table.tcell class="text-right">
                        <x-architect::components.link-button size="small" href="./{{ $route }}/{{ $row->getKey() }}">
                            Edit
                        </x-architect::components.link-button>
                    </x-architect::components.table.tcell>
                @endif
            </tr>
        @endforeach
        </tbody>
    </x-architect::components.table>
</div>
