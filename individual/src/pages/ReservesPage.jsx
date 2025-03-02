import { useEffect, useState } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import BuscadorComponent from '@components/BuscadorComponent';
import estandarImg from '@/assets/habitacio-estandar.avif';
import deluxeImg from '@/assets/habitacio-deluxe.avif';
import suiteImg from '@/assets/habitacio-suite.avif';
import adaptadaImg from '@/assets/habitacio-adaptada.avif';

export default function ReservesPage() {
  const location = useLocation();
  const navigate = useNavigate();
  const queryParams = new URLSearchParams(location.search);

  const dataEntrada = queryParams.get('dataEntrada') || '';
  const dataSortida = queryParams.get('dataSortida') || '';
  const numPersones = queryParams.get('numPersones') || 1;

  const [habitacions, setHabitacions] = useState([]);
  const [showForm, setShowForm] = useState(false);
  const [selectedHabitacio, setSelectedHabitacio] = useState(null);
  const [formData, setFormData] = useState({
    nom: '',
    dni: '',
    email: '',
  });
  const [message, setMessage] = useState('');
  const [reserves, setReserves] = useState([]);

  const apiUrl = import.meta.env.DEV
    ? import.meta.env.VITE_DEV_API_URL
    : import.meta.env.VITE_PROD_API_URL;

  useEffect(() => {
    document.title = 'Sakura | Reserves';

    const fetchHabitacions = async () => {
      try {
        const codiHotel = import.meta.env.VITE_HOTEL_ID;
        const response = await fetch(
          `${apiUrl}/v2/habitacions/${codiHotel}/disponibles?data_entrada=${dataEntrada}&data_sortida=${dataSortida}&capacitat=${numPersones}`
        );
        const data = await response.json();
        setHabitacions(data);
      } catch (error) {
        console.error('Error al cercar habitacions disponibles:', error);
      }
    };

    if (dataEntrada && dataSortida && numPersones) {
      fetchHabitacions();
    }

    fetch(`${apiUrl}/v2/reserves`)
      .then((response) => response.json())
      .then((data) => setReserves(data));
  }, [dataEntrada, dataSortida, numPersones, apiUrl]);

  const handleSelectHabitacio = (habitacio) => {
    setSelectedHabitacio(habitacio);
    setShowForm(true);
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      // Crear o obtener usuario
      const userResponse = await fetch(`${apiUrl}/v2/usuaris`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
      });

      if (!userResponse.ok) {
        throw new Error('Error creant o cercant suuari');
      }

      const userData = await userResponse.json();

      // Crear reserva
      const reservaData = {
        habitacion_id: selectedHabitacio.id,
        usuari_id: userData.id,
        data_entrada: dataEntrada,
        data_sortida: dataSortida,
        preu_total: selectedHabitacio.preuTotal,
        estat: 'Reservada',
      };

      const reservaResponse = await fetch(`${apiUrl}/v1/reserves`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(reservaData),
      });

      if (!reservaResponse.ok) {
        throw new Error('Error al crear la reserva');
      }

      setMessage('Reserva afegida amb èxit!');
      setShowForm(false);
      setHabitacions([]);
    } catch (error) {
      console.error('Error:', error);
    }
  };

  return (
    <div className="reserves-page">
      {!showForm && !message && <BuscadorComponent />}
      {!showForm && !message && habitacions.length > 0 && (
        <div className="habitacions-list">
          {habitacions.map((habitacio) => {
            const numNits =
              (new Date(dataSortida) - new Date(dataEntrada)) /
              (1000 * 60 * 60 * 24);
            const capacitat =
              habitacio.llits + habitacio.llits_supletoris;

            return (
              <div key={habitacio.id} className="habitacio-card">
                <div className="habitacio-card__image">
                  <img
                    src={getHabitacioImage(habitacio.tipus)}
                    alt={habitacio.tipus}
                  />
                </div>
                <div className="habitacio-card__content">
                  <h3 className="habitacio-card__title font-primary">
                    {habitacio.tipus}
                  </h3>
                  <p>
                    <b>Capacitat:</b> {capacitat} persones
                  </p>
                  <div className="habitacio-card__price-container">
                    <p className="habitacio-card__total">
                      {habitacio.preuTotal} €
                    </p>
                    <p className="habitacio-card__price">
                      Preu per {numNits} nit
                      {numNits > 1 ? 's' : ''} i {numPersones} persones
                    </p>
                  </div>
                  <button
                    className="habitacio-card__button"
                    onClick={() => handleSelectHabitacio(habitacio)}
                  >
                    Sel·lecionar
                  </button>
                </div>
              </div>
            );
          })}
        </div>
      )}
      {showForm && (
        <form onSubmit={handleSubmit} className="reserva-form">
			<h1>Reservar</h1>
            <p>Emplena el formulari amb les teves dades</p>
          <div className="form-group">
            <label htmlFor="nom">Nom:</label>
            <input
              type="text"
              id="nom"
              name="nom"
              value={formData.nom}
              onChange={handleChange}
              required
            />
          </div>
          <div className="form-group">
            <label htmlFor="dni">DNI:</label>
            <input
              type="text"
              id="dni"
              name="dni"
              value={formData.dni}
              onChange={handleChange}
              required
            />
          </div>
          <div className="form-group">
            <label htmlFor="email">Email:</label>
            <input
              type="email"
              id="email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              required
            />
          </div>
          <button type="submit" className="submit-btn">Enviar</button>
        </form>
      )}
      {message && (
        <div className="message-container">
          <p>{message}</p>
          <button onClick={() => navigate('/')} className="submit-btn">
            Tornar a l&apos;inici
          </button>
        </div>
      )}
      <div className="reserves">
        {reserves.length === 0 ? (
          <p className="reserves__no-reserves">
            No hi han reserves per mostrar.
          </p>
        ) : (
          reserves.map((reserva) => (
            <div key={reserva.id} className="reserves__card">
              <h2 className="reserves__card-title">{reserva.titol}</h2>
              <p className="reserves__card-description">
                {reserva.descripcio_llarga}
              </p>
            </div>
          ))
        )}
      </div>
    </div>
  );
}

function getHabitacioImage(tipus) {
  switch (tipus) {
    case 'Estandar':
      return estandarImg;
    case 'Deluxe':
      return deluxeImg;
    case 'Suite':
      return suiteImg;
    case 'Adaptada':
      return adaptadaImg;
    default:
      return estandarImg;
  }
}
