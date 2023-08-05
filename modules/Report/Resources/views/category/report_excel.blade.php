<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        <div>
            <h3 align="center" class="title"><strong>REPORT DE CATEGORIAS</strong></h3>
        </div>
        <br>
        <div style="margin-top:20px; margin-bottom:15px;">
            <table>
            
                <tr>
                    <td>
                        <p><b>Empresa: </b></p>
                    </td>
                    <td align="center">
                        <p><strong>{{$company->name}}</strong></p>
                    </td>
                    <td>
                        <p><strong>Fecha: </strong></p>
                    </td>
                    <td align="center">
                        <p><strong>{{date('Y-m-d')}}</strong></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Ruc: </strong></p>
                    </td>
                    <td align="center">{{$company->number}}</td>
                </tr>
            </table>
        </div>
        <br>
        @if(!empty($records))
            <div class="">
                    <table class="">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">Nombre</th>
                                <th class="">Creado por</th>
                                <th class="">Fecha de creacion</th>
                             
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $key => $value)
                            <tr>
                                <td class="celda">{{$loop->iteration}}</td>
                                <td class="celda">{{$value->name}}</td> 
                                <td class="celda">{{$value->user ? $value->user->name : ''}}</td> 
                                <td class="celda">{{$value->created_at}}</td>
                
 
                            </tr>
                          
                            @endforeach
                            
                        </tbody>
                    </table>
            </div>
        @else
            <div>
                <p>No se encontraron registros.</p>
            </div>
        @endif
    </body>
</html>
