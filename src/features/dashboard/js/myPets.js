const myPetsSection = $("section.my-pets");

// Sample data for pets as an array
const myPets = [
    {
        id: 1,
        img: "https://images.unsplash.com/photo-1518717758536-85ae29035b6d?auto=format&fit=facearea&w=400&h=400&facepad=2",
        name: "Daniel",
        breed: "West Highland White Terrier",
        age: "3 years",
        notes: "Loves to wear ties.",
        weight: "32kg",
        height: "99cm",
        vacc: "5",
        grooming: "complete",
    },
    {
        id: 2,
        img: "https://images.pexels.com/photos/1108099/pexels-photo-1108099.jpeg?auto=compress&w=400&h=400&fit=facearea",
        name: "Zeus",
        breed: "Golden Retriever",
        age: "5 years",
        notes: "Enjoys long walks.",
        weight: "28kg",
        height: "85cm",
        vacc: "3",
        grooming: "pending",
    },
    {
        id: 3,
        img: "https://images.pexels.com/photos/4587997/pexels-photo-4587997.jpeg?auto=compress&w=400&h=400&fit=facearea",
        name: "Bella",
        breed: "Labrador Retriever",
        age: "2 years",
        notes: "Loves to swim.",
        weight: "30kg",
        height: "90cm",
        vacc: "4",
        grooming: "complete",
    },
    {
        id: 4,
        img: "https://images.pexels.com/photos/45201/kitty-cat-kitten-pet-45201.jpeg?auto=compress&w=400&h=400&fit=facearea",
        name: "Milo",
        breed: "Beagle",
        age: "4 years",
        notes: "Chases squirrels.",
        weight: "18kg",
        height: "60cm",
        vacc: "6",
        grooming: "pending",
    },
    {
        id: 5,
        img: "https://images.pexels.com/photos/733416/pexels-photo-733416.jpeg?auto=compress&w=400&h=400&fit=facearea",
        name: "Luna",
        breed: "Siberian Husky",
        age: "3 years",
        notes: "Howls at night.",
        weight: "25kg",
        height: "80cm",
        vacc: "5",
        grooming: "complete",
    },
    {
        id: 6,
        img: "https://images.pexels.com/photos/374906/pexels-photo-374906.jpeg?auto=compress&w=400&h=400&fit=facearea",
        name: "Charlie",
        breed: "Pug",
        age: "1 year",
        notes: "Loves belly rubs.",
        weight: "10kg",
        height: "40cm",
        vacc: "2",
        grooming: "pending",
    },
    {
        id: 7,
        img: "https://images.pexels.com/photos/356378/pexels-photo-356378.jpeg?auto=compress&w=400&h=400&fit=facearea",
        name: "Max",
        breed: "German Shepherd",
        age: "6 years",
        notes: "Very protective.",
        weight: "35kg",
        height: "100cm",
        vacc: "7",
        grooming: "complete",
    },
];

/**
 * Populates the .pet-items list with pet data from myPets array.
 * This will replace the current list with the pets in myPets and an Add Pet button.
 */
function populateMyPets() {
    const petItems = myPetsSection.find(".pet-items");
    if (!petItems.length) return;

    petItems.empty();
    let petsHTML = "";

    // Add each pet
    myPets.forEach((pet) => {
        petsHTML += `
            <li class="item view-pet" data-pet-id="${pet.id}">
                <img class="avatar-img" src="${pet.img}" alt="${pet.name}" />
                <div class="avatar-name">${pet.name}</div>
            </li>
        `;
    });
    petItems.append(petsHTML);

    // Add the "Add Pet" button on the last
    petItems.append(`
        <button class="ui circular icon button add-pet-btn" data-open-modal="#addPetModal">
            <i class="plus icon"></i> Add Pet
        </button>
    `);
}

function singleWherePetView(petId = null) {
    if (!petId) return false;
    const petFlyout = $("#petFlyout");

    const pet = myPets.find((p) => p.id === petId);
    $.each(pet, function (name, value) {
        // Remove quotes around ${name} and use correct class selector
        if (name === "img") {
            petFlyout.find(`.pet-profile-img`).attr("src", value);
        } else {
            petFlyout.find(`.pet-profile-${name}`).text(value);
        }
    });

    $("#petFlyout").flyout("show");
}

$(function () {
    populateMyPets();

    $("body").on("click", ".view-pet", function (e) {
        console.log("clickin on pet item");
        const petId = $(this).data("pet-id");

        // Show the pet flyout modal (assumes #petFlyout exists and is initialized)
        singleWherePetView(petId);
    });
});
