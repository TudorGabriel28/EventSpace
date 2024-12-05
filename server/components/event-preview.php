<div class="event-preview">
                <div class="event-preview-image" style="background-image: url('<?= htmlspecialchars($event['coverPhoto']) ?>');">
                    <div class="event-preview-date">
                        On 05/05/2024
                    </div>
                </div>
                <div class="event-preview-info">
                    <h4 class="event-preview-title"><?= htmlspecialchars($event['name']) ?></h4>
                    <div class="event-preview-category-container">
                        <p class="event-preview-category"><?= htmlspecialchars($event['categoryName']) ?></p>
                        <div class="event-preview-location-list">
                            <?php 
                                $locations = json_decode($event['locations'], true); // Decode the JSON array of locations
                                if (!empty($locations)): 
                                    foreach ($locations as $location): ?>
                                            <div class="event-preview-location">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1.5rem" height="1.5rem"><title>map-marker-radius-outline</title><path d="M12 4C14.2 4 16 5.8 16 8C16 10.1 13.9 13.5 12 15.9C10.1 13.4 8 10.1 8 8C8 5.8 9.8 4 12 4M12 2C8.7 2 6 4.7 6 8C6 12.5 12 19 12 19S18 12.4 18 8C18 4.7 15.3 2 12 2M12 6C10.9 6 10 6.9 10 8S10.9 10 12 10 14 9.1 14 8 13.1 6 12 6M20 19C20 21.2 16.4 23 12 23S4 21.2 4 19C4 17.7 5.2 16.6 7.1 15.8L7.7 16.7C6.7 17.2 6 17.8 6 18.5C6 19.9 8.7 21 12 21S18 19.9 18 18.5C18 17.8 17.3 17.2 16.2 16.7L16.8 15.8C18.8 16.6 20 17.7 20 19Z" /></svg>
                                                <p class="event-preview-location-title"><?= htmlspecialchars($location['city']) ?>, <?= htmlspecialchars($location['postalCode']) ?></p>
                                            </div>
                                        
                                    <?php endforeach; 
                                endif; ?>
                        </div>
                    </div>
                </div>
            </div>