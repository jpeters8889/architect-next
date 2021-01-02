<nav class="mt-10">
    <x-architect::layout.sidebar.navigation.wrapper>
        <x-architect::layout.sidebar.navigation.parent>
            <i class="fas fa-home"></i>

            <span class="mx-3">Dashboards</span>
        </x-architect::layout.sidebar.navigation.parent>

        <nav class="-mt-4 bg-gray-700 bg-opacity-60 rounded-b text-gray-100">
                <x-architect::layout.sidebar.navigation.item href="">
                    <i class="text-lg fas fa-door-closed"></i>

                    <span class="mx-3">foo</span>
                </x-architect::layout.sidebar.navigation.item>
        </nav>
    </x-architect::layout.sidebar.navigation.wrapper>

    @foreach($navigation['buildings'] as $building)
        <x-architect::layout.sidebar.navigation.wrapper>
            <x-architect::layout.sidebar.navigation.parent>
                <i class="far fa-building"></i>

                <span class="mx-3">{{ $building['label'] }}</span>
            </x-architect::layout.sidebar.navigation.parent>

            <nav class="-mt-4 bg-gray-700 bg-opacity-60 rounded-b text-gray-100">
                @foreach($building['items'] as $item)
                    <x-architect::layout.sidebar.navigation.item href="{{ $item['url'] }}">
                        <i class="text-lg far fa-map"></i>

                        <span class="mx-3">{{ $item['label'] }}</span>
                    </x-architect::layout.sidebar.navigation.item>
                @endforeach
            </nav>
        </x-architect::layout.sidebar.navigation.wrapper>
    @endforeach
</nav>
