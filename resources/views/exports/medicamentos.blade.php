<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Medicamentos - MedIntera+</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .header h1 { color: #4f46e5; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f3f4f6; color: #374151; font-weight: bold; text-align: left; padding: 8px; border: 1px solid #d1d5db; }
        td { padding: 8px; border: 1px solid #d1d5db; vertical-align: top; }
        .footer { text-align: center; font-size: 10px; color: #6b7280; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>MedIntera+</h1>
        <p>Relatório Multidisciplinar de Medicamentos</p>
        <p>Gerado em: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nome Comercial</th>
                <th>Princípio Ativo</th>
                <th>Classificação</th>
                <th>Sintomatologia / Alterações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicamentos as $med)
            <tr>
                <td><strong>{{ $med->nome_comercial }}</strong></td>
                <td>{{ $med->principioAtivo?->nome_principio_ativo ?? 'N/A' }}</td>
                <td>{{ $med->classificacao?->classificacao ?? 'N/A' }}</td>
                <td>
                    @if($med->sintomatologia)
                        <em>Sintoma:</em> {{ $med->sintomatologia->descricao }} <br>
                    @endif
                    @if($med->alteracaoLaboratorial)
                        <em>Lab:</em> {{ $med->alteracaoLaboratorial->descricao }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Este documento é para apoio à decisão clínica e não substitui a avaliação profissional.
    </div>
</body>
</html>
