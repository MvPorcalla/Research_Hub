var url = window.location.href;

if (url.includes('favorites.php')) {
    document.addEventListener('DOMContentLoaded', () => {
    
        const fetchFavorites = async () => {
            try {
    
                if (document.getElementById('favoriteTiles')) {

                    const favoriteTiles = document.getElementById('favoriteTiles');
    
                    const response = await fetch(`../../backend/fetchRecords.php?fetch=favorites`);
                    if (!response.ok) throw new Error('Network response was not ok');
    
                    const data = await response.json();
    
                    data.forEach(dataRow => {
                        let tileHTML = `
                            <div class="col-12 mb-2">
                                <div class="card border-dark rounded-4">
                                    <div class="card-body" onclick="if (!event.target.closest('button')) { window.location.href='abstractView.php?abstractId=${dataRow.record_id}'; }" style="cursor: pointer;">
                                        <div class="row text-center">
                                            <div class="col-md-11 d-flex align-items-center justify-content-start border-end">${dataRow.title}</div>
                                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                                <button class="btn btn-outline-danger btn-sm mx-1 like-button" data-record-id="${dataRow.record_id}">
                                                    <i class="fas fa-heart"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        favoriteTiles.innerHTML += tileHTML;
                    });
                }
            } catch (error) {
                console.error('Error fetching records:', error);
            }
        };

        fetchFavorites().then(() => { getLikes(); });
    });
}