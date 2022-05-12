import React, { useState, useEffect, useCallback } from "react";
import { useFetch, deleteData } from "../hooks";
import { format } from "date-fns";


function Tab() {
    const { items: users, setImems: setUsers, load, loading } = useFetch('/api/utilisateurs')

    useEffect(() => {
        load()
    }, [])


    return <div><table className="table table-bordered table-sm">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Email</th>
                <th scope="col">Adresse</th>
                <th scope="col">Tel</th>
                <th scope="col">Age</th>
            </tr>
        </thead>
        <tbody>
            {loading ? 'Chargement...' : null}
            {users.map(u => <User key={u.id} user={u} />)}
        </tbody>
    </table >
    </div>

}

function User({ user }) {

    var date = new Date(user.birthDate);
    var formattedDate = format(date, "dd-MM-yyyy");

    const [Age, setAge] = useState([]);

    const getAge = () => {
        fetch("/UserServices/calculAge/" + formattedDate)
            .then((age) => age.json())
            .then((age) => {
                setAge(age);
            });
    }

    useEffect(() => {
        getAge();
    }, []);

    return <tr>
        <td>{user.id}</td>
        <td><a href={`possession?id=${user.id}`}>{user.nom}</a></td>
        <td>{user.prenom}</td>
        <td>{user.email}</td>
        <td>{user.adresse}</td>
        <td>{user.tel}</td>
        <td>{Age}</td>
        <td><button type="button" className="btn btn-danger" onClick={() => deleteData(user.id)} >Supprimer</button></td>
    </tr>
}

function TabDonnees() {
    return <Tab />
}

export default TabDonnees;