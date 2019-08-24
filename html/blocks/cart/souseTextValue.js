export default function (amount) {

    let text = 'бесплатных';

    if(amount === 1 || (amount >= 21 && amount % 10 === 1)) {
        text = 'бесплатный';
    } else {
        text = 'бесплатных';
    }

    return `${amount} ${text}`;
}