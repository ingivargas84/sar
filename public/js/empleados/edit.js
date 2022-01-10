//Date picker
$('#datepickerA').datepicker({
	autoclose: true,
	format: 'dd-mm-yyyy'
  });
  
  $('#datepickerB').datepicker({
	autoclose: true,
	format: 'dd-mm-yyyy'
  });
  
  $('#datepickerN').datepicker({
	autoclose: true,
	format: 'dd-mm-yyyy'
  });

function cuiIsValid(cui) {
    var console = window.console;
    if (!cui) {
        console.log("CUI vacío");
        return true;
    }

    var cuiRegExp = /^[0-9]{4}\s?[0-9]{5}\s?[0-9]{4}$/;

    if (!cuiRegExp.test(cui)) {
        console.log("CUI con formato inválido");
        return false;
    }

    cui = cui.replace(/\s/, '');
    var depto = parseInt(cui.substring(9, 11), 10);
    var muni = parseInt(cui.substring(11, 13));
    var numero = cui.substring(0, 8);
    var verificador = parseInt(cui.substring(8, 9));
    
    // Se asume que la codificación de Municipios y 
    // departamentos es la misma que esta publicada en 
    // http://goo.gl/EsxN1a

    // Listado de municipios actualizado segun:
    // http://goo.gl/QLNglm

    // Este listado contiene la cantidad de municipios
    // existentes en cada departamento para poder 
    // determinar el código máximo aceptado por cada 
    // uno de los departamentos.
    var munisPorDepto = [ 
        /* 01 - Guatemala tiene:      */ 17 /* municipios. */, 
        /* 02 - El Progreso tiene:    */  8 /* municipios. */, 
        /* 03 - Sacatepéquez tiene:   */ 16 /* municipios. */, 
        /* 04 - Chimaltenango tiene:  */ 16 /* municipios. */, 
        /* 05 - Escuintla tiene:      */ 13 /* municipios. */, 
        /* 06 - Santa Rosa tiene:     */ 14 /* municipios. */, 
        /* 07 - Sololá tiene:         */ 19 /* municipios. */, 
        /* 08 - Totonicapán tiene:    */  8 /* municipios. */, 
        /* 09 - Quetzaltenango tiene: */ 24 /* municipios. */, 
        /* 10 - Suchitepéquez tiene:  */ 21 /* municipios. */, 
        /* 11 - Retalhuleu tiene:     */  9 /* municipios. */, 
        /* 12 - San Marcos tiene:     */ 30 /* municipios. */, 
        /* 13 - Huehuetenango tiene:  */ 32 /* municipios. */, 
        /* 14 - Quiché tiene:         */ 21 /* municipios. */, 
        /* 15 - Baja Verapaz tiene:   */  8 /* municipios. */, 
        /* 16 - Alta Verapaz tiene:   */ 17 /* municipios. */, 
        /* 17 - Petén tiene:          */ 14 /* municipios. */, 
        /* 18 - Izabal tiene:         */  5 /* municipios. */, 
        /* 19 - Zacapa tiene:         */ 11 /* municipios. */, 
        /* 20 - Chiquimula tiene:     */ 11 /* municipios. */, 
        /* 21 - Jalapa tiene:         */  7 /* municipios. */, 
        /* 22 - Jutiapa tiene:        */ 17 /* municipios. */ 
    ];
    
    if (depto === 0 || muni === 0)
    {
        console.log("CUI con código de municipio o departamento inválido.");
        return false;
    }
    
    if (depto > munisPorDepto.length)
    {
        console.log("CUI con código de departamento inválido.");
        return false;
    }
    
    if (muni > munisPorDepto[depto -1])
    {
        console.log("CUI con código de municipio inválido.");
        return false;
    }
    
    // Se verifica el correlativo con base 
    // en el algoritmo del complemento 11.
    var total = 0;
    
    for (var i = 0; i < numero.length; i++)
    {
        total += numero[i] * (i + 2);
    }
    
    var modulo = (total % 11);
    
    console.log("CUI con módulo: " + modulo);
    return modulo === verificador;
}


$.validator.addMethod("dpi", function(value, element) {
		var valor = value;
		if (cuiIsValid(valor) == true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}, "El CUI/DPI ingresado está incorrecto");

//Funcion para validar NIT

function nitIsValid(nit) {
	if (!nit) {
		return true;
	}

	var nitRegExp = new RegExp('^[0-9]+(-?[0-9kK])?$');

	if (!nitRegExp.test(nit)) {
		return false;
	}

	nit = nit.replace(/-/, '');
	var lastChar = nit.length - 1;
	var number = nit.substring(0, lastChar);
	var expectedCheker = nit.substring(lastChar, lastChar + 1).toLowerCase();

	var factor = number.length + 1;
	var total = 0;

	for (var i = 0; i < number.length; i++) {
		var character = number.substring(i, i + 1);
		var digit = parseInt(character, 10);

		total += (digit * factor);
		factor = factor - 1;
	}

	var modulus = (11 - (total % 11)) % 11;
	var computedChecker = (modulus == 10 ? "k" : modulus.toString());

	return expectedCheker === computedChecker;
}



$.validator.addMethod("nit", function(value, element){
var valor = value;

if(nitIsValid(valor)==true)
{
	return true;
}

else
{
	return false;
}
}, "El NIT ingresado es incorrecto o inválido, reviselo y vuelva a ingresarlo");


$.validator.addMethod("ntel", function(value, element) {
	var valor = value.length;
	if (valor == 8)
	{
		return true;
	}
	else
	{
		return false;
	}
}, "Debe ingresar el número de teléfono con 8 dígitos, en formato ########");

var validator = $("#EmpleadoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		emp_cui: {
			required : true,
			dpi : true
		},
		nit:{
			nit:true
		},
		nombres: {
			required : true
		},
		apellidos: {
			required : true
		},

		direccion: {
			required : true
		},
		celular: {
			ntel:true,
			required : true
		},

		puesto_id: {
			required : true
		},

		fecha_nacimiento: {
			required : true
		},
		email:{
			email: true
		}

	},
	messages: {
		emp_cui: {
			required: "Por favor, ingrese el CIU/DPI del empleado"
		},
		nombres: {
			required: "Por favor, ingrese el nombre del empleado"
		},
		apellidos: {
			required: "Por favor, ingrese el apellido del empleado"
		},

		direccion: {
			required: "Por favor, ingrese la dirección del empleado"
		},

		celular: {
			required: "Por favor, ingrese el número de celular"
		},

		puesto_id: {
			required: "Por favor, seleccione el puesto del empleado"
		},

		fecha_nacimiento: {
			required: "Por favor, seleccione fecha de nacimiento"
		},

		email: {
			email: "El formato de correo no es correcto"
		}

	}
});

$("#ButtonEmpleadoUpdate").click(function(event) {
	if ($('#EmpleadoUpdateForm').valid()) {
		$('.loader').addClass("is-active");

	} else {
		validator.focusInvalid();
	}
});