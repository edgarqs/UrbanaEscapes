import {useState} from 'react';
import {useNavigate} from 'react-router-dom';

export default function BuscadorComponent() {
	// Obtener parámetros de la URL si existen
	const params = new URLSearchParams(window.location.search);
	const urlDataEntrada = params.get('dataEntrada') || '';
	const urlDataSortida = params.get('dataSortida') || '';
	const urlNumPersones = params.get('numPersones') || 1;

	// Estados con valores predeterminados de la URL o valores por defecto
	const [entrada, setEntrada] = useState(urlDataEntrada);
	const [sortida, setSortida] = useState(urlDataSortida);
	const [persones, setPersones] = useState(urlNumPersones);
	const [errors, setErrors] = useState({
		entrada: '',
		sortida: '',
		persones: '',
	});

	const navigate = useNavigate();

	// Función para obtener la fecha de hoy en formato YYYY-MM-DD
	const getTodayDate = () => {
		const today = new Date();
		const yyyy = today.getFullYear();
		const mm = String(today.getMonth() + 1).padStart(2, '0');
		const dd = String(today.getDate()).padStart(2, '0');
		return `${yyyy}-${mm}-${dd}`;
	};

	// Validaciones
	const validateForm = () => {
		const today = getTodayDate();
		let valid = true;
		let newErrors = {entrada: '', sortida: '', persones: ''};

		// Validar fecha de entrada
		if (!entrada || entrada < today) {
			newErrors.entrada =
				'La data de entrada ha de ser posterior a avui.';
			valid = false;
		}

		// Validar fecha de salida
		if (!sortida || sortida <= entrada) {
			newErrors.sortida =
				'La data de sortida ha de ser posterior a la de entrada.';
			valid = false;
		}

		// Validar número de personas
		const num = parseInt(persones, 10);
		if (isNaN(num) || num < 1 || num > 6) {
			newErrors.persones = 'El número de persones ha de ser entre 1 i 6.';
			valid = false;
		}

		setErrors(newErrors);
		return valid;
	};

	// Manejar el envío del formulario
	const handleSubmit = (e) => {
		e.preventDefault();

		// Si el formulario es válido, redirigir a /reserves con los parámetros
		if (validateForm()) {
			const queryParams = new URLSearchParams({
				dataEntrada: entrada,
				dataSortida: sortida,
				numPersones: persones,
			}).toString();

			navigate(`/reserves?${queryParams}`);
		}
	};

	return (
		<div>
			<form
				className="form-buscador"
				onSubmit={handleSubmit}>
				<div className="form-buscador__input">
					<label htmlFor="dataEntrada">Data entrada</label>
					<input
						type="date"
						id="dataEntrada"
						value={entrada}
						onChange={(e) => setEntrada(e.target.value)}
						min={getTodayDate()}
						required
					/>
					{errors.entrada && (
						<p className="error-message">{errors.entrada}</p>
					)}
				</div>

				<div className="form-buscador__input">
					<label htmlFor="dataSortida">Data sortida</label>
					<input
						type="date"
						id="dataSortida"
						value={sortida}
						onChange={(e) => setSortida(e.target.value)}
						min={entrada || getTodayDate()}
						required
					/>
					{errors.sortida && (
						<p className="error-message">{errors.sortida}</p>
					)}
				</div>

				<div className="form-buscador__input">
					<label htmlFor="numPersones">Nombre de persones</label>
					<input
						type="number"
						id="numPersones"
						value={persones}
						onChange={(e) => setPersones(e.target.value)}
						min={1}
						max={6}
						required
					/>
					{errors.persones && (
						<p className="error-message">{errors.persones}</p>
					)}
				</div>

				<button type="submit">Enviar</button>
			</form>
		</div>
	);
}
