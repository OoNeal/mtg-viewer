export async function   fetchAllCards() {
    const response = await fetch('/api/card/all');
    if (!response.ok) throw new Error('Failed to fetch cards');
    return await response.json();
}

export async function fetchCardsByName(name) {
    const response = await fetch(`/api/card/search/${name}`);
    if (response.status === 404) return null;
    if (!response.ok) throw new Error('Failed to fetch card');
    return await response.json();
}

export async function fetchCard(uuid) {
    const response = await fetch(`/api/card/${uuid}`);
    if (response.status === 404) return null;
    if (!response.ok) throw new Error('Failed to fetch card');
    const card = await response.json();
    card.text = card.text.replaceAll('\\n', '\n');
    return card;
}

export async function fetchSetCode() {
    const response = await fetch('/api/card/set-codes');
    if (!response.ok) throw new Error('Failed to fetch set code');
    return await response.json();
}
