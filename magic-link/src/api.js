import magicLinkRequest from "./magicLinkRequest";

export const searchMeetings = async (params) => {
    return magicLinkRequest('search_meetings', params)
}

export const getMeeting = async (id) => {
    return magicLinkRequest('meeting', {
        'meeting_id': id
    })
}

export const getMeetings = async (params) => {
    return magicLinkRequest('meetings', params)
}

export const login = async (data) => {
    return magicLinkRequest('login', data, 'POST')
}

export const logout = async (data) => {
    return magicLinkRequest('logout', data, 'POST')
}

export const createAccount = async (data) => {
    return magicLinkRequest('register', data, 'POST')
}

export const getGroups = async (data) => {
    return magicLinkRequest('groups', data, 'GET')
}

export const saveMeeting = async (data) => {
    return magicLinkRequest('meeting', data, 'PUT')
}

export const createMeeting = async (data) => {
    return magicLinkRequest('meeting', data, 'POST')
}

