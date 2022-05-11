import { useState, useCallback } from "react";
import { async } from "regenerator-runtime";


export function useFetch(url) {
    const [loading, setLoading] = useState(false)
    const [items, setItems] = useState([])
    const load = useCallback(async () => {
        setLoading(true)
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/ld+json'
            }
        })
        const responseData = await response.json()
        if (response.ok) {
            setItems(items => [...items, ...responseData['hydra:member']])
            setItems(responseData['hydra:member'])

        } else {
            console.error(responseData)
        }
        setLoading(false)

    }, [url])

    return {
        items,
        load,
        loading,
    }

}


export async function deleteData(id) {
    const response = await fetch(`/api/utilisateurs/${id}`, {
        method: "DELETE",
    });
    window.location.reload(true);
}