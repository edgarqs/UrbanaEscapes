import {useEffect} from 'react';

export default function FeedbackPage() {
    useEffect(() => {
        document.title = 'Sakura | Feedback';
    }, []);

    return (
        <div className='feedback-page'>
            <h2>f</h2>
            <div className='feedback-form'>
                <h2 className='feedback-form titulo'>Feedback</h2>
                <textarea className='feedback-form__textarea' name="" id=""></textarea>
                <button className='feedback-form__btn'>Enviar Feedback</button>
            </div>
        </div>
    );
}
