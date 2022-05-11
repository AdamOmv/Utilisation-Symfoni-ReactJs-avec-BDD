import React, { useState, useEffect, useCallback } from "react";
import { useFetch, deleteData, possFetch } from "../hooks";
import { format } from "date-fns";

const queryStringUrlId = window.location.search;
const urlSearchParams = new URLSearchParams(queryStringUrlId);
const userId = urlSearchParams.get("id");
console.log(userId);

/* function PossFetch() {
    const [loading, setLoading] = possFetch(false)
    const [items, setImets] = possFetch([])
    const load = useCallback(async () => {
        setLoading(true)
        const response = await fetch("/api/utilisateurs/" + userId)
            .then((user) => user.json())
            .then((user) => {
                setUser(user);
                /* console.log(user.possessions[1]) 
                for (let i = 0; i < user.possessions.length; i++) {
                    fetch(user.possessions[i])
                        .then((poss) => poss.json())
                }
            });

        const responseData = await response.json
        if (response.ok) {
            setItems(items => [...items, ...poss])
            setItems(poss)
        } else {
            console.error(responseData)
        }
        setLoading(false)
    }, [])

    return {
        items,
        load,
        loading,
    }
} */
/* const [User, setUser] = useState([]);
const [loading, setLoading] = useState(false);
const [Poss, setPoss] = useState([]);


const getUser = () => {
    fetch("/api/utilisateurs/" + userId)
        .then((user) => user.json())
        .then((user) => {
            setUser(user);
            /* console.log(user.possessions[1]) 
            for (let i = 0; i < user.possessions.length; i++) {
                fetch(user.possessions[i])
                    .then((poss) => poss.json())
                    .then((poss) => {
                        setPoss(...Poss, poss);
                        /* Poss.push(poss) 
                    });
            }
        });
}
console.log(Poss)

useEffect(() => {
    getUser();
}, []); */

function Tab() {

    const { items: Poss, setImems: setPoss, load, loading } = useFetch("/api/possessions/")
    const { items: User, setImems: setUsers, load: loadUsers, loading: loadingUsers } = useFetch("/api/utilisateurs/")

    useEffect(() => {
        load()
        loadUsers()
    }, [])

    /*     const [Users, setUser] = useState([]);
    
        const getUser = () => {
            fetch("/monApi/utilisateurs/59")
                .then((user) => user.json())
                .then((user) => {
                    setUser(user);
                });
        }
        console.log(Users)
    
        useEffect(() => {
            getUser();
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