{{-- Selo do papel na campanha. $papel é o enum App\Enums\PapelCampanha (usa ->name e ->rotulo()). --}}
@php $classe = \Illuminate\Support\Str::slug($papel->name); @endphp
<span class="selo selo--{{ $classe }}">{{ mb_strtoupper($papel->rotulo()) }}</span>
