<template>
    <bracket :rounds="rounds">
        <template slot="player" slot-scope="{ player }">
            {{ player.name }}
        </template>
    </bracket>
</template>

<script>
import Bracket from "vue-tournament-bracket";

const rounds = [{
        games: [{
                player1: { id: "1", name: "Competitor 1", winner: null },
                player2: { id: "2", name: "Competitor 2", winner: null },
            },
            {
                player1: { id: "3", name: "Competitor 3", winner: null },
                player2: { id: "4", name: "Competitor 4", winner: null },
            }
        ]
    },
    {
        games: [{
                player1: { id: "2", name: "match1勝者", winner: null },
                player2: { id: "4", name: "match2勝者", winner: null },
            }
        ]
    }
];
export default {
    props:{
        test:{
            type: Object
        },
        players:{
            type: Object
        },
    },
    components: {
        Bracket
    },
    data() {
        return {
            rounds: rounds
        }
    },
}

</script>
