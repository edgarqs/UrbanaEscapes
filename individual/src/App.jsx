import { BrowserRouter as Router, Route, Routes } from 'react-router';
import '@/styles/main.scss';

//? Componentes:
import HeaderComponent from '@components/HeaderComponent';
import FooterComponent from '@components/FooterComponent';

//? Páginas:
import MainPage from '@pages/Home/HomePage';
import NoticiesPages from '@pages/Noticies/NoticiesPage';

function App() {

  return (
    <Router>
      <HeaderComponent />
      <Routes>
        <Route path="/" element={<MainPage />} />
        <Route path="/noticies" element={<NoticiesPages />} />
      </Routes>
      <FooterComponent />
    </Router>
  );
}

export default App;