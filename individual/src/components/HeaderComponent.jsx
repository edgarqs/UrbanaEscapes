export default function HeaderComponent() {
	return (
		<header className="header">
			<a href="/"><h2 className="header__logo">sakura</h2></a>
			{/* <img src="./../../public/sakura-logo.avif" alt="logo sakura" /> */}
			<nav className="header__nav">
				<ul className="header__menu">
					<li className="header__item">
						<a href="/" className="header__link">Inicio</a>
					</li>
					<li className="header__item">
						<a href="/noticies" className="header__link">Notícies</a>
					</li>
				</ul>
			</nav>
		</header>
	);
}
