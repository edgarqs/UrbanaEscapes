import { BrowserRouter as Router, Route, Routes } from 'react-router';
import '@/styles/main.scss';

//? Componentes:
import HeaderComponent from '@components/HeaderComponent';
import FooterComponent from '@components/FooterComponent';

//? Páginas:
import MainPage from '@pages/HomePage';
import NoticiesPage from '@pages/NoticiesPage';
import ReservesPage from '@pages/ReservesPage';

export default function App() {
  return (
    <Router>
      <HeaderComponent />
      <Routes>
        <Route path="/" element={<MainPage />} />
        <Route path="/noticies" element={<NoticiesPage />} />
        <Route path="/reserves" element={<ReservesPage />} />
      </Routes>
      <FooterComponent />
    </Router>
  );
}
