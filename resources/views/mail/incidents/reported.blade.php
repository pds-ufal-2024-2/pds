<x-mail::message>
# Novo incidente reportado

Obrigado por reportar um incidente em nosso sistema. Aqui estão os detalhes do problema reportado:

<x-mail::panel>
**Código do Incidente:** {{ $incident->code }}

**Categoria:** {{ $incident->category }}
</x-mail::panel>

<x-mail::button :url="$incident_url">
Ver Incidente
</x-mail::button>

</x-mail::message>