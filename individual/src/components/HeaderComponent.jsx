import { NavLink } from 'react-router';

export default function HeaderComponent() {
    return (
        <header className="header">
            <a href="/" className="header__logo">
                <img src="./../../public/sakura-icono.avif" alt="logo sakura" />
            </a>
            <nav className="header__nav">
                <ul className="header__menu">
                    <li className="header__item">
                        <NavLink to="/" className={({ isActive }) => isActive ? "header__link header__link--active" : "header__link"}>
                            Inici
                        </NavLink>
                    </li>
                    <li className="header__item">
                        <NavLink to="/noticies" className={({ isActive }) => isActive ? "header__link header__link--active" : "header__link"}>
                            Notícies
                        </NavLink>
                    </li>
                    <li className="header__item">
                        <NavLink to="/reserves" className={({ isActive }) => isActive ? "header__link header__link--active" : "header__link"}>
                            Reservar Habitació
                        </NavLink>
                    </li>
                </ul>
            </nav>
        </header>
    );
}
