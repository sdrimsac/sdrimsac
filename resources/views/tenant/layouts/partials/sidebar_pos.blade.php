@php
    $path = explode('/', request()->path());
    $path[0] = $path[0] === '' ? 'documents' : $path[0];
    $path[1] = array_key_exists(1, $path) > 0 ? $path[1] : '';
    $path[2] = array_key_exists(2, $path) > 0 ? $path[2] : '';
@endphp

<div class="menu-container ">
    {{-- <ul>
        <li class="modulo-caja">
            <h1 style=" color: white; font-size: 250%; font-weight: bold; margin-top: 21px ">CAJA</h1>
        </li>
    </ul> --}}
</div>
<style>
    @media (max-width: 850px) {
        .modulo-caja {
            display: none;
        }
    }

    @media (min-width: 851px) {
        .modulo-caja {
            display: block;
        }
    }
</style>
