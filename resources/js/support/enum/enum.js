export class Enum {
    constructor(value) {
        this.value = value;
    }

    isEquals(value) {
        return value === this;
    }

    toString() {
        return `${this.value}`;
    }
}
