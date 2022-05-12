import React, { useState, useEffect, useCallback } from "react";
import { useFetch, deleteData, possFetch } from "../hooks";
import { format } from "date-fns";

const queryStringUrlId = window.location.search;
const urlSearchParams = new URLSearchParams(queryStringUrlId);
const userId = urlSearchParams.get("id");
console.log(userId);

function Tab() {

    const { items: Poss, setImems: setPoss, load, loading } = useFetch("/api/possessions/")
    const { items: User, setImems: setUsers, load: loadUsers, loading: loadingUsers } = useFetch("/api/utilisateurs/")

    useEffect(() => {
        load()
        loadUsers()
    }, [])

    /* const [Poss, setPoss] = useState([]);

    const getPoss = () => {
        fetch("/monApi/possessions")
            .then((poss) => poss.json())
            .then((poss) => {
                setPoss(poss);
            });
    }
    console.log(Poss)

    const [User, setUser] = useState([]);

    const getUser = () => {
        fetch("/monApi/utilisateurs")
            .then((user) => user.json())
            .then((user) => {
                setUser(user);
            });
    }
    console.log(User)

    useEffect(() => {
        getPoss()
        getUser()
    }, []); */

    return (
        <div>
            <h1>Informations sur l'utilisateur : {userId}</h1>
            {loadingUsers ? 'Chargement...' : null}
            {User.map(u => <TabUser key={u.id} user={u} />)}
            <table className="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Valeur</th>
                        <th scope="col">Type</th>
                    </tr>
                </thead>
                <tbody>
                    {loading ? 'Chargement...' : null}
                    {Poss.map(p => <TabPoss key={p.id} poss={p} />)}
                </tbody>

            </table >
        </div>

    )
}

function TabUser({ user }) {

    var date = new Date(user.birthDate);
    var formattedDate = format(date, "dd/MM/yyyy")

    if (user.id == userId) {
        return (<div><ul className="list-group">
            <li className="list-group-item">Id : {user.id}</li>
            <li className="list-group-item">Nom : {user.nom}</li>
            <li className="list-group-item">Prenom : {user.prenom}</li>
            <li className="list-group-item">Email : {user.email}</li>
            <li className="list-group-item">Adresse : {user.adresse}</li>
            <li className="list-group-item">Telephone : {user.tel}</li>
            <li className="list-group-item">Date de naissance : {formattedDate}</li>
        </ul>
        </div >
        )
    }
}

function TabPoss({ poss }) {

    const Uid = "/api/utilisateurs/" + userId

    if (poss.utilisateurs == Uid) {
        return <tr>
            <td>{poss.id}</td>
            <td>{poss.nom}</td>
            <td>{poss.valeur}</td>
            <td>{poss.type}</td>
        </tr>

    }
}

function TabPossessions() {
    return <div><Tab /></div>
}

export default TabPossessions;