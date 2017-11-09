const MULTIPLIERS = [1, 2, 1, 2, 1, 2, 1, 2, 1, 2, 1];
const IDENTIFICATION_LENGTH = 11;

export default {
    validateIdentification(identification = '') {
        const id = identification.replace(/-+/g, ''),
            idLength = id.length;

        if (idLength !== IDENTIFICATION_LENGTH) {
            return false;
        }

        let total = 0;
        let digit = 0;

        for (; digit < IDENTIFICATION_LENGTH; digit++) {
            const num = Number.parseFloat(id[digit]) * MULTIPLIERS[digit];

            if (num < 10) {
                total += num;
            } else {
                const numString = num.toString();
                total += Number.parseFloat(numString[0]) + Number.parseFloat(numString[1]);
            }
        }

        return total % 10 === 0;
    }
};