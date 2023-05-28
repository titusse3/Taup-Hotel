if (!localStorage.getItem('token')) {
    window.location = '../';
}

$.post('../api/v1/account/get/', 
    JSON.stringify({token: localStorage.getItem('token')}), d => {
    if (d.code !== 'good') {
        console.log("Failed to get account data");
        window.location = '../';   
    }
    const type = d.data.TYPE;
    const id = d.data.ID;
    if (type == 'ADMIN') {
        $('main').append('<h4>', {
            class: 'other-sec',
            text: 'Admin'
        })
        const contain = $('<div>', {class: 'contain'});
        const contain_past2 = $('<div>', {class: 'contain-past2'});
        $('main').append(contain);
        contain.append(contain_past2);
        contain_past2.append('<h3>', {text: 'User'});
        const username = $('<input>', {
            id: 'input-user',
            name: 'username',
            placeholder: 'User'
        })
        contain_past2.append(username);
        const container2 = $('<div>', {class: 'give-note'});
        contain_past2.append(container2);
        let nextUser = null;

        function addUser() {
            for (let i = 0; i < arguments.length; ++i) {
                const main = $('<form>', {
                    class: 'annouce note-contain grant-edit',
                    value: arguments[i].ID
                });
                const info = $('<div>', {class: 'annouche-info'});
                const lname = $('<h7>', {text: arguments[i].LNAME});
                const fname = $('<h7>', {text: arguments[i].FNAME});
                const select = $('<select>', {
                    name: 'type_user',
                    required: true
                });
                const option1 = $('<option>', {
                    value: 'CLIENT',
                    text: 'Client'
                });
                const option2 = $('<option>', {
                    value: 'ADMIN',
                    text: 'Admin'
                });
                const option3 = $('<option>', {
                    value: 'MANAGER',
                    text: 'Manager'
                });
                const tabs = [option1, option2, option3];
                for (let j = 0; j < tabs.length; ++j) {
                    if (tabs[j].val() == arguments[i].TYPE) {
                        console.log('sale')
                        tabs[j].attr('selected', 'true');
                        break;
                    }
                }
                const perm = $('<input>', {
                    placeholder: 'Perm',
                    name: 'perm',
                    type: 'number', 
                    value: arguments[i].PERM
                })
                const submit = $('<input>', {
                    type: 'submit',
                    value: 'Grant'
                })
                const img = $('<img>', {
                    src: '../src/img/croix.svg',
                    class: 'delete-user'
                })
                info.append(lname);
                info.append(fname);
                main.append(info);
                select.append(option1);
                select.append(option2);
                select.append(option3);
                main.append(select);
                main.append(perm);
                main.append(submit);
                main.append(img);
                container2.append(main);
            }
        }

        function fetchUser() {
            let body = {
                token: localStorage.getItem('token'),
                name: username.val(),
                next: nextUser
            }
            body = JSON.stringify(body, (_, value) => {if (value) return value})
            $.post('../api/v1/user/', body, d => {
                if (d.code !== 'good') {
                    return;
                }
                addUser(...(d.data || []));
                nextUser = d.next || null;
                $('.grant-edit').off('submit')
                $('.grant-edit').on('submit', event => {
                    event.preventDefault();
                    const element = $(event.target);
                    const id = element.attr('value');

                    const type_user = element.find('select[name="type_user"]');
                    const perm = element.find('input[name="perm"]');

                    const body = {
                        token: localStorage.getItem('token'),
                        perm: perm.val(),
                        type: type_user.val(),
                        id: id
                    }
                    $.post('../api/v1/user/grant/', JSON.stringify(body), d => {
                        if (d.code !== 'good') {
                            return;
                        }
                        element.css('border', '3px solid green');
                        setTimeout(() => {
                            element.css('border', '');
                        }, 2000)
                    })
                })

                $('.delete-user').off('click');
                $('.delete-user').on('click', event => {
                    event.preventDefault();
                    const element = $(event.target);
                    const parent = element.closest('form');
                    const id = parent.attr('value');
                    const body = {
                        token: localStorage.getItem('token'),
                        id: id
                    }

                    $.post('../api/v1/user/delete/', JSON.stringify(body), d => {
                        if (d.code !== 'good') {
                            return;
                        }
                        parent.remove();
                    })
                });
            })
        }

        fetchUser();

        container2.on('scroll', event => {
            if (nextUser && container2.scrollTop() > container2[0].scrollHeight - 
                container2.innerHeight() - 
                (container2.children().first().innerHeight() || 0)) {
                fetchUser();
            }
        })

        username.on('change', event => {
            nextUser = null;
            container2.children().remove();
            fetchUser();
        })
    }
    if (type == 'MANAGER') {
        $('main').append($('<h4>', {
            text: 'Post Hotel/Room',
            class: 'other-sec'
        }));
        const bouttons = $('<div>', {class: 'contain boutton-contain'});
        bouttons.append($('<a>', {
            class: 'post-rh',
            text: 'Hotel',
            href: '../hotel/post'
        }))
        bouttons.append($('<a>', {
            class: 'post-rh',
            text: 'Room',
            href: '../room/post'
        }))
        $('main').append(bouttons);
    }
    if (type != 'CLIENT') {


        $('main').append($('<h4>', {
            text: 'Hotel/Room',
            class: 'other-sec'
        }));
        const mym = $('<div>', {
            class: 'mym'
        });
        $('main').append(mym);
        mym.append('<section class="search-barre-section"><form class="search-barre"><input placeholder="Destination" name="dest" /><input placeholder="Name" name="name" /><input placeholder="Departure" name="departure" type="date" required /><input placeholder="Arrived" name="arrived" type="date" required /><div class="left-search"> <input placeholder="Lit" name="bed" type="number" min="1" required /><div class="recherche-button-bar"><input type="submit" value="Submit" /><svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="display: block; fill: none; height: 16px; width: 16px; stroke: currentcolor; stroke-width: 4px; overflow: visible;" aria-hidden="true" role="presentation" focusable="false"><g fill="none"><path d="m13 24c6.0751322 0 11-4.9248678 11-11 0-6.07513225-4.9248678-11-11-11-6.07513225 0-11 4.92486775-11 11 0 6.0751322 4.92486775 11 11 11zm8-3 9 9"></path> </g></svg></div></div></form></section>');
        mym.append('<div class="filter"> Sort by <select name="trie" id="trie-button"> <option selected="selected" disabled>Price</option> <option value="">Peu importe</option> <option value="ASC">↑ (croissant)</option> <option value="DESC">↓ (décroissant)</option> </select> <select name="note" id="etoile-button"> <option selected="selected" disabled>Notation</option> <option value="">Peu importe</option> <option value="1">★</option> <option value="2">★★</option> <option value="3">★★★</option> <option value="4">★★★★</option> <option value="5">★★★★★</option> </select> <select name="type" id="room-button"> <option selected="selected" disabled>Type</option> <option value="">Peu importe</option> <option value="HOTEL">Hotel</option> <option value="ROOM">Room</option> </select> <select name="type_room" id="type-room-button"> <option selected="selected" disabled>Type of Room</option> <option value="">Peu importe</option> <option value="DORTORY">Dortory</option> <option value="SOLO">Private Room</option> </select> </div>');
        const container = $('<div>', {class: 'contain-annonce'});
        mym.append(container);

        $("#room-button").on("change", ()=> {
            if ($("#room-button").val() == 'ROOM') {
                $("#type-room-button").css('visibility', 'visible');
            } else {
                if ($("#type-room-button").css('visibility') == 'visible') {
                    $("#type-room-button").css('visibility', 'hidden');
                }
            }
        });

        function daysBetween(startDate, endDate) {
            return (endDate - startDate) / (24 * 60 * 60 * 1000);;
        }
        
        let next = null;
        const form = $('form.search-barre');
        const dest = $('input[name="dest"]');
        const name_ = $('input[name="name"]');
        const arrived = $('input[name="arrived"]');
        const departure = $('input[name="departure"]');
        const bed = $('input[name="bed"]');
        const trie = $('select[name="trie"]');
        const note = $('select[name="note"]');
        const type = $('select[name="type"]');
        const type_room = $('select[name="type_room"]');
        
        const currentDate = new Date();
        currentDate.setDate(currentDate.getDate() + 1);
        let year = currentDate.getFullYear();
        let month = String(currentDate.getMonth() + 1).padStart(2, '0');
        let day = String(currentDate.getDate()).padStart(2, '0');
        departure.val(year + '-' + month + '-' + day)
        
        currentDate.setDate(currentDate.getDate() + 8);
        year = currentDate.getFullYear();
        month = String(currentDate.getMonth() + 1).padStart(2, '0');
        day = String(currentDate.getDate()).padStart(2, '0');
        arrived.val(year + '-' + month + '-' + day);
        
        bed.val(1);
        
        fetch();
        
        function addElement() {
            const nbDays = daysBetween(new Date(departure.val()).getTime(), 
                new Date(arrived.val()).getTime());
            for (let i = 0; i < arguments.length; ++i) {
                const a = $('<a>', {
                    class: 'annonce-block',
                    href: '../' + (arguments[i]['TYPE'] == 'HOTEL' ? 
                        'hotel?id=' + arguments[i]['ID'] : 
                        'room?' + (new URLSearchParams({
                            id: arguments[i]['ID'],
                            place: bed.val(),
                            departure: new Date(departure.val()).getTime(),
                            arrived: new Date(arrived.val()).getTime()
                        })).toString())
                });
                const img_block = $('<div>', {class: 'img-block'});
                const img_annonce = $('<img>', {
                    class: 'img-annonce',
                    src: arguments[i]['IMG0']
                });
                const type_block = $('<div>', {class: 'type-block'});
                const type = $('<img>', {
                    src: arguments[i]['TYPE'] == 'HOTEL' ? '../src/img/hotel2.svg' 
                        : '../src/img/Lit.svg'
                });
                const title = $('<h4>', {
                    text: arguments[i]['TYPE'] == 'HOTEL' ? 'Hotel' : 'Room'
                });
                const heart_block = $('<div>', {class: 'heart-block'});
                const heart = $('<img>', {src: '../src/img/heart.svg'});
                const note = $('<h4>', {
                    text: parseFloat(arguments[i]['NOTE']).toFixed(2)
                });
                const bottom_block = $('<div>', {class: 'bottom-block'});
                const info = $('<div>');
                const name = $('<h3>', {text: arguments[i]['NAME']});
                const address = $('<h4>', {
                    text: arguments[i]['COUNTRY'] + ', ' + arguments[i]['CITY'] 
                        + ', ' + arguments[i]['ADDRESS']
                });
                const price_block = $('<h4>');
                const price = $('<span>', {
                    text: (arguments[i]['PRICE'] * nbDays).toFixed(2)
                });
                const bottom_block2 = $('<div>', {class: 'bottom-block'})
                const edit = $('<img>', {
                    src: '../src/img/edit.svg',
                    class: 'edit',
                    value: arguments[i]['TYPE'] + '-' + arguments[i].ID
                })
                const croix = $('<img>', {
                    class: 'croix',
                    src: '../src/img/croix.svg',
                    value: arguments[i]['TYPE'] + '-' + arguments[i].ID
                })
                container.append(a);
                a.append(img_block);
                img_block.append(img_annonce);
                img_block.append(type_block);
                type_block.append(type);
                type_block.append(title);
                img_block.append(heart_block);
                heart_block.append(heart);
                heart_block.append(note);
                a.append(bottom_block);
                bottom_block.append(info);
                info.append(name);
                info.append(address);
                bottom_block.append(price_block);
                price_block.append(price);
                price_block.append(' Total');
                bottom_block2.append(edit);
                bottom_block2.append(croix);
                a.append(bottom_block2)
            }
        }
        
        function fetch() {
            let body = {
                dfrom: new Date(departure.val()).getTime() / 1000,
                dto: new Date(arrived.val()).getTime() / 1000,
                place: bed.val(),
                city: dest.val(),
                address: dest.val(),
                country: dest.val(),
                name: name_.val(),
                order: trie.val(),
                min_note: note.val(),
                type: type.val(),
                type_room: type_room.val(),
                next: next,
                user: type == 'MANAGER' ? id : null,
            };
            body = JSON.stringify(body, (_, value) => {if (value) return value})
            $.post('../api/v1/search/', body, (data) => {
                if (data.code == 'good') {
                    if (data.data) {
                        addElement(...data.data);
                    } else if (!next) container.append($('<p>', {
                        text: data.success[0],
                        class: 'erreur'
                    }));
                } else if (!next) container.append($('<p>', {
                    text: data.reason[0],
                    class: 'erreur'
                }));
                next = data.next || null;
                $('.croix').off('click');
                $('.croix').on('click', event => {
                    event.preventDefault();
                    const element = $(event.target);
                    const type_id = element.attr('value').split('-');
                    if (type_id[0] == 'HOTEL') {
                        $.post('../api/v1/hotel/delete/', 
                            JSON.stringify({
                                token: localStorage.getItem('token'),
                                hotel: type_id[1]
                            }), d => {
                                if (d.code == 'good') {
                                    element.closest('.annonce-block').remove();
                                }
                            })
                    } else {
                        $.post('../api/v1/room/delete/', 
                        JSON.stringify({
                            token: localStorage.getItem('token'),
                            room: type_id[1]
                        }), d => {
                            if (d.code == 'good') {
                                element.closest('.annonce-block').remove();
                            }
                        })
                    }
                })

                $('.edit').off('click');
                $('.edit').on('click', event => {
                    event.preventDefault();
                    const element = $(event.target);
                    const type_id = element.attr('value').split('-');
                    if (type[0] == 'HOTEL') {
                        window.location = '../hotel/edit?id=' + type_id[1];
                    } else {
                        window.location = '../room/edit?id=' + type_id[1];
                    }
                });
            })
        }
        
        form.on('submit', event => {
            event.preventDefault();
            container.children().remove();
            next = null;
            fetch();
        })
        
        $(window).on('scroll', event => {
            if (next && $(this).scrollTop() > container.innerHeight() 
                + container.offset().top - $('footer').innerHeight() 
                - (container.children().first().innerHeight() || 0)) {
                fetch();
            }
        })
    }
});

const capitalize = str => str.split(' ').map(s => s.charAt(0).toUpperCase() 
    + s.slice(1)).join(' ');

const g_note = $('.give-note').eq(0);
const sessions = $('.give-note').eq(2);
const note = $('input[name="note"]');
const persoform = $('.personal-information')
const lastname = $('input[name="name"]');
const firstname = $('input[name="firstname"]');
const email = $('input[name="email"]');
const password = $('input[name="password"]');
const phone = $('input[name="phone"]');
const newpassword = $('input[name="newpassword"]');

const sessionData = [];
let sessionNext = null;


function addReservation() {
    for (let i = 0; i < arguments.length; ++i) {
        const redirect = $('<a>', {
            href: '../room?id=' +  arguments[i].ID,
        })
        const a = $('<div>', {class: 'annouce'});
        const img = $('<img>', {src:  arguments[i].IMG0});
        const annouche = $('<div>', {class: 'annouche-info'});
        const h6 = $('<h6>', {text: arguments[i].NAME})
        const address = $('<h7>', {text: arguments[i].COUNTRY.toUpperCase() + 
            ', ' + capitalize(arguments[i].CITY) + ', ' + arguments[i].ADDRESS});
        const date = $('<h7>', {
            text: arguments[i].DFROM.replaceAll('-', '/') + ' to ' + 
                arguments[i].DTO.replaceAll('-', '/')
        })
        const form = $('<form>');
        const input = $('<input>', {
            placeholder: 'Note',
            type: 'number',
            name: 'note',
            value: arguments[i].NOTE,
            required: true
        })
        const submit = $('<input>', {
            type: 'submit',
            value: 'Note'
        })
        const star = $('<div>', {class:'star'});
        for(let i = 0; i < 5; ++i) {
            star.append($('<img>', {src: '../src/img/heart.svg'}));
        }
        a.append(redirect);
        redirect.append(img);
        redirect.append(annouche);
        annouche.append(h6);
        annouche.append(address);
        annouche.append(date);
        a.append(form)
        form.append(input);
        form.append(submit)
        a.append(star);
        g_note.append(a);
    }
}

$.post('../api/v1/account/reserve/', 
    JSON.stringify({token: localStorage.getItem('token')}), d => {
    if (d.code !== 'good') {
        window.location = '../';   
    }
    addReservation(...(d.data || []));
    $('.annouce form').on('submit', event => {
        event.preventDefault();
        const ind = $('.annouce form').index($(event.target));
        const body = {
            token: localStorage.getItem('token'),
            room: d.data[ind].ID,
            dto: (new Date(d.data[ind].DTO)).getTime() / 1000,
            dfrom: (new Date(d.data[ind].DFROM)).getTime() / 1000,
            note: $(event.target).find('input[name="note"]').val()
        }
        $.post('../api/v1/account/reserve/note/', JSON.stringify(body), d => {
            if (d.code !== 'good') {
                $(event.target).find('input[name="note"]').val(-1)
            }
            $(event.target).find('input[name="note"]').css('border', '3px solid green');
            setTimeout(() => {
                $(event.target).find('input[name="note"]').css('border', '');
            }, 1000)
        })
    })
    
})

persoform.on('submit', event => {
    event.preventDefault();
    let body = {
        firstname: firstname.val(),
        name: lastname.val(),
        phone: phone.val(),
        email: email.val(),
        newpassword: newpassword.val(),
        password: password.val(),
        token: localStorage.getItem('token')
    }
    body = JSON.stringify(body, (_, value) => {if (value) return value})
    $.post('../api/v1/account/change/', body, d => {
        if (d.code !== 'good') {
            persoform.append($('<p>', {text: d.reason[0]}));
            return;
        }
        persoform.append($('<p>', {text: d.success[0]}));
        lastname.val(null);
        firstname.val(null);
        phone.val(null);
        email.val(null);
        password.val(null);
        newpassword.val(null);
    })
})
/*
<div class="annouce note-contain session-contain">
<h7>Ceci est une ssession</h7>
<h7>18/06/2030</h7>
<img class="delete-session" src="../src/img/croix.svg" />
</div>*/

function addSession() {
    for (let i = 0; i < arguments.length; ++i) {
        const div = $('<div>', {class: 'annouce note-contain session-contain'});
        const name = $('<h7>', {text: arguments[i].NAME});
        const date = $('<h7>', {text: arguments[i].DC});
        const img = $('<img>', {
            src: '../src/img/croix.svg',
            class: 'delete-session',
            value: arguments[i].ID
        })
        div.append(name);
        div.append(date);
        div.append(img);
        sessions.append(div);
    }
}

function fetchSession() {
    $.post('../api/v1/account/session/', 
        JSON.stringify({
            token: localStorage.getItem('token'), 
            next: sessionNext
        }), d => {
        if (d.code !== 'good') {
            return;
        }
        addSession(...(d.data || []));
        sessionData.push(...(d.data || []));
        sessionNext = d.next || null;
        $('.delete-session').off('click');
        $('.delete-session').on('click', event => {
            event.preventDefault();
            const element = $(event.target);
            const id = element.attr('value');

            $.post('../api/v1/account/session/delete/', JSON.stringify({
                token: localStorage.getItem('token'), 
                session: id
            }), d => {
                if (d.code == 'good') {
                    element.closest('.session-contain').remove();
                }
            })
        });
    })
}

fetchSession();

sessions.on('scroll', event => {
    if (sessionNext && sessions.scrollTop() > sessions[0].scrollHeight - 
        sessions.innerHeight() - (sessions.children().first().innerHeight() || 0)) {
        fetchSession();
    }
})

$('.button-id-disco').on('click', event => {
    event.preventDefault();

    $.post('../api/v1/account/disconnect/', 
        JSON.stringify({token: localStorage.getItem('token')}), d => {
        if (d.code == 'good') {
            localStorage.removeItem('token');
            window.location = '../';
        }
    })
})