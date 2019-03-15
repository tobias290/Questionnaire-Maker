export class User {
    private readonly _id: number;
    private readonly _email: string;
    private readonly _firstName: string;
    private readonly _surname: string;
    private readonly _dateJoined: string;
    
    public constructor(user) {
        this._id = user.id;
        this._email = user.email;
        this._firstName = user.first_name;
        this._surname = user.surname;
        this._dateJoined = user.date_joined;
    }
    
    get id() {
        return this._id;
    }
    
    get email() {
        return this._email;
    }

    get firstName() {
        return this._firstName;
    }

    get surname() {
        return this._surname;
    }

    get fullName() {
        return `${this.firstName} ${this.surname}`;
    }

    get dateJoined() {
        return this._dateJoined;
    }
}
