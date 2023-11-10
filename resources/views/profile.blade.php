<html>
    <head>
        <title>Perfil</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    </head>
    <body>

	<table style="width:100%" class="table table-borderless" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td>
                    <table cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td>
                                    <img src="{{ 'https://unixfystorage.blob.core.windows.net/unixfy-recruiting/'.$imageURI }}" class="img-thumbnail border-0" alt="...">
                                </td>
                            </tr>
                            <tr style="background-color:#333">
                                <td style="color:#fff;" class="text-center"><strong>Contacto</strong></td>
                            </tr>
                            @foreach($profiles as $profile)
                                <tr style="background-color:#333">
                                    <td style="color:#fff" class="text-center">{{ $profile->user->email }}</td>
                                </tr>
                                <tr style="background-color:#333">
                                    <td style="color:#fff" class="text-center">{{ strtoupper($profile->phone) }} / {{ strtoupper($profile->phone2) }}</td>
                                </tr>
                            @endforeach
                            <tr style="background-color:#333">
                                <td style="color:#fff" class="text-center"><strong>Habilidades y Dest.</strong></td>
                            </tr>
                            <tr style="background-color:#333">
                                <td style="color:#fff" class="text-center"><strong>Areas de interés</strong></td>
                            </tr>  
                        </tbody>                      
                    </table>
                </td>
				<td>
                    @foreach($profiles as $profile)
                        <h3>{{ strtoupper($profile->first_name) .' '. strtoupper($profile->last_name) }}</h3>
                        <p>{{ $description }}</p>
                    @endforeach
                    
                    <h3>Educación</h3>
                    <table class="table table-sm" cellspacing="0" cellpadding="0">
                        @foreach ($profiles as $profile)
                            @foreach ($profile->educations as $education)
                                <tr>
                                    <?php
                                        $fecha = null;
                                        if($education->currently == 1){
                                            $fecha = "Actualidad";
                                        }else{
                                            $fecha = 'Desde: '.$education->date_from.' Hasta: '.$education->date_to;
                                        }

                                        $tesis = null;
                                        if(!empty($education->tesis_title)){
                                            $tesis = 'Título de Tesis: '.$education->tesis_title;
                                        }else{
                                            $tesis = '';
                                        }
                                    ?>
                                    <td>
                                        {{ $fecha }} {{ $education->institution }}
                                        <br>
                                        {{ $education->level }} - {{ $education->title }}
                                        <br>
                                        {{ $tesis }}
                                    </td>
                                </tr>
                            @endforeach                
                        @endforeach
                    </table>

                    <h3>Experiencia Laboral</h3>
                    <table class="table table-sm" cellspacing="0" cellpadding="0">        
                        @foreach ($profiles as $profile)
                            @foreach ($profile->experiences as $experience)
                                <tr>
                                    <?php
                                        $fecha = null;
                                        if($experience->currently == 1){
                                            $fecha = "Actualidad";
                                        }else{
                                            $fecha = 'Desde: '.$experience->date_from.' Hasta: '.$experience->date_to;
                                        }
                                    ?>
                                    <td>
                                        {{ $fecha }} {{ $experience->company_name }}
                                        <br>
                                        Cargo: {{ $experience->position }}
                                        <br>
                                        Funciones: {{ $experience->functions }}
                                        <br>
                                        Referencia laboral: {{ $experience->reference_name }} - {{ $experience->reference_phone }}
                                    </td>
                                </tr>
                            @endforeach                
                        @endforeach
                    </table>
                </td>
            </tr>
		</tbody>
        <tfoot>
            <tr>
                <td colspan="2">Descargado desde app recruiting</td>
            </tr>
        </tfoot>
	</table>
    
    </body>
</html>


