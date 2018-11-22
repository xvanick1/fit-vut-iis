
export class Role {
  id: string;
}

export class User {
  username: string;
  password: string;
  isActive: boolean;
  role: string;
  name: string;
  surname: string;
  id: number;
  _submitted: boolean;
}
